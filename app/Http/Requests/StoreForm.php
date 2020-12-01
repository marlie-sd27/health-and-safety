<?php

namespace App\Http\Requests;

use App\Rules\ValidDates;
use App\Rules\ValidInterval;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use function GuzzleHttp\Psr7\str;

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
            'first_occurence_at' => ['string','nullable', new ValidDates(), 'required_with:interval'],
            'interval' => ['string','nullable', new ValidInterval()],
            'required_for' => 'nullable|in:Staff,Sites',
            'requirees_sites' => 'required_if:required_for,Sites',
            'requirees_sites.*' => 'exists:sites,id',
            'requirees_groups' => 'required_if:required_for,Staff',
            'requirees_groups.*' => 'exists:groups,id',
            'requirees_emails' => 'nullable|string',
            'full_year' => 'boolean',

            'section_title' => 'nullable|array',
            'section_title.*' => 'string|max:255',
            'section_description' => 'array|nullable',
            'section_description.*' => 'string|nullable',

            'label' => 'array|nullable',
            'label.*' => ['required','string'],
            'type' => 'array|nullable',
            'type.*' => 'in:select,text,textarea,number,radio,checkbox,slider,date,time,file',
            'required' => 'array|nullable',
            'options' => 'array|nullable',
            'options.*' => 'string|nullable',
            'help' => 'array|nullable',
            'help.*' => 'string|nullable'
        ];
    }


    // sanitize the user input
    protected function prepareForValidation()
    {
        // sanitize each section title, section description, label and options and helps
        $section_titles = array();
        $section_descriptions = array();
        $labels = array();
        $options = array();
        $help = array();
        $requirees_sites = array();
        $requirees_groups = array();


        if (isset($this->section_title))
        {
            foreach ($this->section_title as $key => $value) {
                $section_titles[$key] = str_replace(['<','>'], "", $value);
                $section_descriptions[$key] = str_replace(['<','>'], "", $this->section_description[$key]);
            }
        }

        if (isset($this->label))
        {
            foreach ($this->label as $key => $value)
            {
                $labels[$key] = str_replace(['<','>'], "", $value);
                $options[$key] = str_replace(['<','>'], "", $this->options[$key]);
                $help[$key] = str_replace(['<','>'], "", $this->help[$key]);
            }
        }

        if (isset($this->requirees_sites))
        {
            foreach ($this->requirees_sites as $key => $value) {
                $requirees_sites[$key] = str_replace(['<','>'], "", $value);
                $requirees_sites[$key] = str_replace(['<','>'], "", $this->requirees_sites[$key]);
            }
        }

        if (isset($this->requirees_groups))
        {
            foreach ($this->requirees_groups as $key => $value) {
                $requirees_groups[$key] = str_replace(['<','>'], "", $value);
                $requirees_groups[$key] = str_replace(['<','>'], "", $this->requirees_groups[$key]);
            }
        }


        $this->merge([
            'title' => str_replace(['<','>'], "", $this->form_title),
            'description' => str_replace(['<','>'], "", $this->form_description),
            'interval' => $this->interval == "" ? null : str_replace(['<','>'], "", $this->interval),
            'first_occurence_at' => $this->first_occurence_at == "" ? null : str_replace(['<','>'], "", $this->first_occurence_at),
            'required_for' => str_replace(['<','>'], " ", $this->required_for),
            'requirees_emails' => empty(trim($this->requirees_emails)) ? null : trim(str_replace(['<','>'], "", $this->requirees_emails)),
            'full_year' => isset($this->full_year),

            'requirees_sites' => $requirees_sites,
            'requirees_groups' => $requirees_groups,

            'section_title' => $section_titles,
            'section_description' => $section_descriptions,

            'label' => $labels,
            'options' => $options,
            'help' => $help,
        ]);
    }
}
