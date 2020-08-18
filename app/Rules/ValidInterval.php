<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Log;

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
        // convert value into array, splitting along spaces
        $array = explode(" ", $value);
        $valid_time_units = ['year',' years','month','months','week','weeks','day','days'];

        // loop through array.
        for($i = 0; $i < sizeof($array); $i++)
        {
            Log::debug($i % 2);
            //Every even value, validate that it's an integer (since index starts on zero)
            if( $i % 2 == 0)
            {
                $is_valid = filter_var($array[$i], FILTER_VALIDATE_INT);
                Log::debug('odd: ' . $is_valid);
            }
            // Every odd value, validate that it's a legit unit of time
            else {
                $is_valid = in_array( $array[$i], $valid_time_units);
                Log::debug('even: ' . $is_valid);
            }

            // if not valid at any point, return false
            if (!$is_valid)
            {
                return false;
            }
        }

        // if you make if through the loop without returning false, interval is valid, return true
        return true;
    }

    // error message returned if rule fails
    public function message()
    {
        return 'The interval is not valid. Must be in format "quantity unit ..." where quantity must be a valid integer and unit must be year(s), month(s), week(s), or day(s)';
    }
}
