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
        return [
            'forms_id' => 'exists:forms',
            'events_id' => 'exists:events|nullable',
            'data' => 'string',
            'site' => ['string', new ValidSite()],
        ];
    }


    // sanitize the user input
    protected function prepareForValidation()
    {
        // sanitize each entry in the data array
        $data = array();

        if (isset($this->data))
        {
            foreach ($this->data as $key => $value) {
                $cleanedKey = filter_var($key, FILTER_SANITIZE_STRING);
                $cleanedValue = is_array($value) ? $value : filter_var($value, FILTER_SANITIZE_STRING);

                $data[$cleanedKey] = $cleanedValue;
            }
        }

        $this->merge([
            'data' => http_build_query($data),
            'site' => filter_var($this->site, FILTER_SANITIZE_STRING),
        ]);
    }
}
