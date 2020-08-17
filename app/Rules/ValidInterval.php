<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidInterval implements Rule
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

    // determine if the interval is valid
    public function passes($attribute, $value)
    {
        // TODO: write logic
    }

    // error message returned if rule fails
    public function message()
    {
        return 'The interval is not valid. Must be in format "quantity unit ..."';
    }
}
