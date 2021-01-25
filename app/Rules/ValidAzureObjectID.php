<?php

namespace App\Rules;

use App\Helpers\GraphAPIHelper;
use Illuminate\Contracts\Validation\Rule;

class ValidAzureObjectID implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return GraphAPIHelper::testAzureObjectIDValidity($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Azure Group Object ID is not valid!';
    }
}
