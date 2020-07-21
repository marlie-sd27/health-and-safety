<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreForm extends FormRequest
{
    // determine if user is authorized to make request
    public function authorize()
    {
        return true;
    }

    // validate the user input
    public function rules()
    {
        return [
            'title' => 'sometimes|required|max:255',
            'description' => 'string|nullable',
            'first_occurence_at' => 'string|nullable',
            'interval' => 'string|nullable',
            'required_for' => 'nullable|in:All Staff,Principals and Vice Principals',
            'full_year' => 'boolean',

            'section_title' => 'nullable|array',
            'section_title.*' => 'string|max:255',
            'section_description' => 'array|nullable',
            'section_description.*' => 'string|nullable',

            'label' => 'array|nullable',
            'label.*' => 'required|string|distinct',
            'type' => 'array|nullable',
            'type.*' => 'in:select,text,textarea,number,radio,checkbox,slider,date,time',
            'required' => 'array|nullable',
            'options' => 'array|nullable',
            'options.*' => 'string',
        ];
    }


    // sanitize the user input
    protected function prepareForValidation()
    {
        // sanitize each section title, section description, label and options
        $section_titles = array();
        $section_descriptions = array();
        $labels = array();
        $options = array();

        if (isset($this->section_title))
        {
            foreach ($this->section_title as $key => $value) {
                $section_titles[$key] = filter_var($value, FILTER_SANITIZE_STRING);
                $section_descriptions[$key] = filter_var($this->section_description[$key], FILTER_SANITIZE_STRING);
            }
        }

        if (isset($this->label))
        {
            foreach ($this->label as $key => $value)
            {
                $labels[$key] = filter_var($value, FILTER_SANITIZE_STRING);
                $options[$key] = filter_var($this->options[$key], FILTER_SANITIZE_STRING);
            }
        }


        $this->merge([
            'title' => filter_var($this->form_title, FILTER_SANITIZE_STRING),
            'description' => filter_var($this->form_description, FILTER_SANITIZE_STRING),
            'interval' => filter_var($this->interval, FILTER_VALIDATE_INT),
            'first_occurence_at' => filter_var($this->first_occurence_at, FILTER_SANITIZE_STRING),
            'required_for' => '[' . filter_var($this->required_for, FILTER_SANITIZE_STRING) . ']',
            'full_year' => isset($this->full_year),

            'section_title' => $section_titles,
            'section_description' => $section_descriptions,

            'label' => $labels,
            'options' => $options,
        ]);
    }
}
