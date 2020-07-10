<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreForm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
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
            'recurrence' => 'string|nullable',
            'required_role' => 'nullable|in:All Staff, Principals and Vice Principals',
            'full_year' => 'boolean',

            'section_title' => 'nullable|array',
            'section_title.*' => 'string|max:255',
            'section_description' => 'array|nullable',
            'section_description.*' => 'string|nullable',

            'label' => 'array|nullable',
            'label.*' => 'required|string|distinct',
            'type' => 'array|nullable',
            'type.*' => 'in:select,text,textarea,number,radio,checkbox,slider',
            'required' => 'array|nullable',
            'required.*' => 'boolean',
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
            'rec_quantity' => filter_var($this->rec_quantity, FILTER_VALIDATE_INT),
            'rec_repeat' => filter_var($this->rec_repeat, FILTER_VALIDATE_INT),
            'rec_time_unit' => filter_var($this->rec_time_unit, FILTER_SANITIZE_STRING),
            'recurrence' => $this->rec_quantity !== null ? $this->rec_quantity . "," . $this->rec_repeat . "," . $this->rec_time_unit : null,
            'required_role' => filter_var($this->required_role, FILTER_SANITIZE_STRING),
            'full_year' => isset($this->full_year),

            'section_title' => $section_titles,
            'section_description' => $section_descriptions,

            'label' => $labels,
            'options' => $options,
        ]);
    }
}
