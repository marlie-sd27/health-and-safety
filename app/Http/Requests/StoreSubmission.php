<?php

namespace App\Http\Requests;

use App\Rules\ValidSite;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class StoreSubmission extends FormRequest
{
    // determine if user is authorized to make request
    public function authorize()
    {
        return true;
    }

    // validate request with rules
    public function rules()
    {
        $rules = [];

        $rules['forms_id'] = 'exists:forms';
        $rules['events_id'] = 'exists:events|nullable';
        $rules['data'] = 'string';
        $rules['site'] = ['string', new ValidSite()];

        $files = [];

        foreach($this->allFiles() as $key => $value)
        {
            $rules[$key] = 'file|max:10240|mimes:jpeg,png,pdf,docx,txt,doc';
        }

        return $rules;
    }


    // sanitize the user input
    protected function prepareForValidation()
    {
        // sanitize each entry in the data array
        $data = array();

        if (isset($this->data))
        {
            foreach ($this->data as $key => $value) {
                $cleanedKey = str_replace(['<','>'], " ", $key);
                $cleanedValue = is_array($value) ? $value : str_replace(['<','>'], " ", $value);

                $data[$cleanedKey] = $cleanedValue;
            }
        }

        $this->merge([
            'data' => http_build_query($data),
            'site' => filter_var($this->site, FILTER_SANITIZE_STRING),
        ]);
    }
}
