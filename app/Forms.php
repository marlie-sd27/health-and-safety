<?php

namespace App;

use App\Http\Requests\StoreForm;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Forms extends Model
{
    protected $fillable = [
        'title', 'description', 'recurrence', 'required_role', 'full_year'
    ];


    // get the sections and fields for a form
    public function fullForm()
    {
        $this->recurrence = $this->recurrence !== null ? explode(',', $this->recurrence) : null;

        $this['sections'] = $this->sections;

        foreach ($this['sections'] as $section)
        {
            $section['fields'] = $section->fields;

            // convert string into array on comma delimiter
            foreach ($section['fields'] as $field)
            {
                $field->options = explode(',', $field->options);
            }
        }

        return $this;
    }


    // Get the sections for a form
    public function sections()
    {
        return $this->hasMany('App\Sections');
    }


    // Get the submissions for a form
    public function submissions()
    {
        return $this->hasMany('App\Submissions');
    }


    // Create sections and fields for the form
    public function createSectionsandFields(StoreForm $request)
    {

        // keep track of any errors that exist while submitting the form
        $errors = array();

        $section_ids = array();

        // create each section in the form
        if (isset($request->section_title))
        {
            foreach ($request->section_title as $key => $value)
            {
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


        // create each field in the form
        if (isset($request->label))
        {
            foreach ($request->label as $key => $value)
            {
                Fields::create([
                    'sections_id' => $section_ids[$request->section_id[$key]],
                    'label' => $value,
                    'name' => $value,
                    'type' => $request->type[$key],
                    'required' => isset($request->required[$key]),
                    'options' => $request->options[$key],
                ]);
            }
        }

        return $errors;

    }


    public function deleteAllSectionsandFields()
    {
        $sections = $this->sections;

        foreach($sections as $section)
        {
            Fields::destroy($section->fields->modelKeys());
            Sections::destroy($section->id);
        }
    }
}
