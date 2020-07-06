<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class Forms extends Model
{
    protected $fillable = [
        'title', 'description', 'recurrence', 'required_role', 'full_year'
    ];


    // get the sections and fields for a form
    public function fullForm()
    {
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

//        dd($this);
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
    public function createSectionsandFields(Request $request)
    {

        // keep track of any errors that exist while submitting the form
        $errors = array();


        // create each section in the form
        $section_ids = array();

        if (isset($request['section_title']))
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
                $section_ids[$request['id'][$key]] = $section->id;
            }
        }


        // create each field in the form
        if (isset($request['label']))
        {
            foreach ($request->label as $key => $value)
            {
                Fields::create([
                    'sections_id' => $section_ids[$request['section_id'][$key]],
                    'label' => $value,
                    'name' => $value,
                    'type' => $request['type'][$key],
                    'required' => isset($request['required'][$key]),
                ]);
            }
        }

        return $errors;

    }
}
