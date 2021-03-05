<?php

namespace App;

use App\Helpers\CollectionHelper;
use App\Helpers\GraphAPIHelper;
use App\Helpers\Helper;
use App\Helpers\QueryHelper;
use App\Http\Requests\StoreForm;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Forms extends Model
{
    protected $fillable = [
        'title', 'description', 'first_occurence_at', 'interval', 'required_for', 'full_year', 'live', 'requirees_groups', 'requirees_emails', 'requirees_sites'
    ];


    // Get the sections for a form
    public function sections()
    {
        return $this->hasMany('App\Sections')->orderBy('id', 'asc');
    }


    // Get the submissions for a form
    public function submissions()
    {
        return $this->hasMany('App\Submissions');
    }


    // get the events for a form
    public function events()
    {
        return $this->hasMany('App\Events');
    }


    // get the sections and fields for a form
    public function fullForm()
    {
        $this['sections'] = $this->sections;

        foreach ($this['sections'] as $section) {
            $section['fields'] = $section->fields;

            // convert string into array on comma delimiter
            foreach ($section['fields'] as $field) {
                $field->options = $field->options !== "" ? explode(',', $field->options) : "";
            }
        }

        $this['requirees_sites'] = explode(',', $this->requirees_sites);
        $this['requirees_groups'] = explode(',', $this->requirees_groups);

        return $this;
    }


    // Create sections and fields for the form
    public function createSectionsandFields(StoreForm $request)
    {
        // keep track of any errors that exist while submitting the form
        $errors = array();

        $section_ids = $this->createSections($request);

        // create each field in the form
        if (isset($request->field_id)) {
            foreach ($request->field_id as $key => $value) {
                Fields::create([
                    'sections_id' => $section_ids[$request->section_id[$key]],
                    'label' => $request->label[$key],
                    'name' => Str::random(),
                    'type' => $request->type[$key],
                    'required' => isset($request->required[$value]),
                    'options' => $request->options[$key],
                    'help' => $request->help[$key],
                ]);

            }
        }

        return $errors;
    }


    public function createSections(StoreForm $request)
    {
        $section_ids = array();

        // create each section in the form
        if (isset($request->section_title)) {
            foreach ($request->section_title as $key => $value) {
                $section = Sections::create([
                    'title' => $value,
                    'forms_id' => $this->id,
                    'description' => $request->section_description[$key],
                ]);

                // store the newly created section ID in an array
                // key: ID of the section passed in the request. value: newly created section ID in database
                // to be used when creating fields associated with the section
                $section_ids[$request['s_id'][$key]] = $section->id;
            }
        }

        return $section_ids;
    }


    public function updateSectionsandFields(StoreForm $request)
    {
        // recreate all the sections
        $old_sections = $this->sections;
        $section_ids = $this->createSections($request);

        // loop through each field in the request and compare to the section's fields
        if (isset($request->field_id)) {
            foreach ($request->field_id as $key => $value) {

                // search database for field with unique name
                $field = array_key_exists($key, $request->field_name) ? Fields::where('name', 'like', '%' . $request->field_name[$key] . '%')
                    ->whereIn('sections_id', $old_sections->modelKeys())
                    ->firstOrFail() : null;

                // if the field exists, update it
                if ($field) {
                    $field->update([
                        'sections_id' => $section_ids[$request->section_id[$key]],
                        'label' => $request->label[$key],
                        'type' => $request->type[$key],
                        'required' => isset($request->required[$value]),
                        'options' => $request->options[$key],
                        'help' => $request->help[$key],
                    ]);

                    $field->save();

                } else {
                    // if the field is new, add it to the database
                    Fields::create([
                        'sections_id' => $section_ids[$request->section_id[$key]],
                        'label' => $request->label[$key],
                        'name' => Str::random(),
                        'type' => $request->type[$key],
                        'required' => isset($request->required[$value]),
                        'options' => $request->options[$key],
                        'help' => $request->help[$key],
                    ]);

                }
            }
        }

        // delete all the old sections (deleted fields will also be deleted)
        Sections::destroy($old_sections->modelKeys());
    }


    public function closestDueDate()
    {
        $first_overdue = new Collection();
        // check if there are any overdue assignment deadlines for this form/user is they are not a principal
        if (!Auth::user()->principal) {
            $first_overdue = QueryHelper::getOverdues(Auth::user()->email, $this->title);
        } else {
            // if principal, get overdues for the user and the site
            $first_overdue = QueryHelper::getOverdues(null, $this->title)->filter(function ($value, $key) {
                return $value->email = Auth::user()->email or $value->code = Auth::user()->site;
            });
        }


        // if there is an overdue assignment, return the event id
        if($first_overdue->isNotEmpty())
        {
            return $first_overdue->first()->id;
        }

        // otherwise, check for the next closest assignment deadline for this user/form
        $next_deadline = Events::join('assignments', 'assignments.events_id', '=', 'events.id')

            // if the user is a principal, return assignments for the user AND for the school
            ->when(Auth::user()->principal, function($query) {
                return $query->where( function($query) {
                    $query->where('assignments.email', Auth::user()->email)
                        ->orWhere('assignments.sites_id', Auth::user()->getSites_id());
                });
            })
            ->when(!Auth::user()->principal, function ($query) {
                return $query->where('assignments.email', Auth::user()->email);
            })
            ->where('date', '>=', Carbon::now())
            ->where('events.forms_id', '=', $this->id)
            ->whereNotIn('events.id', function ($query) {
                $query->select('events_id')
                    ->from('submissions')
                    ->where('email', Auth::user()->email)
                    ->get();
            })
            ->select('events.*')
            ->orderBy('date', 'asc')
            ->first();

        // if there is an upcoming assignment, return the event id
        if($next_deadline)
        {
            return $next_deadline->id;
        }

        // if the user has no assignment for this form, return null
        else return null;
    }

    public function deleteEvents()
    {
        foreach ($this->events as $event) {
            Events::destroy($event->id);
        }
    }


    public function deleteAssignments()
    {
        foreach($this->events as $event)
        {
            $event->deleteAssignments();
        }
    }
}
