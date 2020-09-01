<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidDates implements Rule
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


    // determine if the attribute passes validation
    public function passes($attribute, $value)
    {
        // allow null values
        if($value == null)
            return true;

        // if the string contains a comma, split into an array and validate each date entry
        if (strstr($value, ",") !== false)
        {
            $dates = explode(",", $value);

            // loop through each date in array
            foreach ($dates as $date)
            {
                // if checkDateFormat returns false, break loop and return false
                if(!$this->checkDateFormat($date))
                {
                    return false;
                }
            }

            // if you make if through the loop without returning false, dates are all valid, return true
            return true;

        }

        // single date was entered, so check date and return result
        else {
            return $this->checkDateFormat($value);
        }
    }


    // error message returned if rule fails
    public function message()
    {
        return 'Something is wrong with one of your due dates. Dates must be separated by a comma and in the format yyyy-mm-dd. Make sure each entry is a valid date';
    }


    // validate proper date format
    public function checkDateFormat($date)
    {
        if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $date))
        {
            return date("Y-m-d", strtotime($date)) == $date;

        } else return false;
    }
}
