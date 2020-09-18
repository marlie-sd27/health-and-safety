<?php

namespace App;

use App\Helpers\Helper;
use App\Http\Requests\StoreForm;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Forms extends Model
{
    protected $fillable = [
        'title', 'description', 'first_occurence_at', 'interval', 'required_for', 'full_year', 'live'
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
                $field = array_key_exists($key, $request->field_name) ? Fields::where('name', $request->field_name[$key])->firstOrFail() : null;

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

//                    if($field->name == "SVxYJt0kfiUt0hGt")
//                        break;

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
        // get all the relevant overdue dates for this event for this user
        $overdues = Events::join('forms', 'forms_id', '=', 'forms.id')
            ->where('date', '<', Carbon::now())
            ->where('events.forms_id', '=', $this->id)
            ->whereNotIn('events.id', function ($query) {
                $query->select('events_id')
                    ->from('submissions')
                    ->where('email', Auth::user()->email)
                    ->get();
            })
            ->select('events.*')
            ->orderBy('date', 'desc')
            ->get();

        $overdues = Helper::filterEvents($overdues);


        // get the next closest due date for this event for this user
        $next_due_date = Events::join('forms', 'forms_id', '=', 'forms.id')
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
            ->get();

        $next_due_date = Helper::filterEvents($next_due_date);


        // if there's an overdue event for this form, return it's id
        if (sizeof($overdues) > 0) {
            return $overdues->first()->id;
        } // otherwise, if there's an upcoming due date for it, return the upcoming id
        else if (sizeof($next_due_date) > 0) {
            return $next_due_date->first()->id;
        } // otherwise return null
        else return null;
    }

    public function deleteAllFutureEvents()
    {
        $events = $this->events;
        foreach ($events as $event) {
            if ($event->date > Carbon::today()) {
                Events::destroy($event->id);
            }
        }
    }
}
