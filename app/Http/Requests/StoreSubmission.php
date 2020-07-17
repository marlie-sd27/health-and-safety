<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            //
        ];
    }


    protected function prepareForValidation()
    {

    }
}
