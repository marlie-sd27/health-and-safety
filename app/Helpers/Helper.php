<?php


namespace App\Helpers;


use App\Submissions;
use Illuminate\Support\Facades\Auth;

class Helper
{

    public static function makeDateReadable($date)
    {
        return date('M d/y', strtotime($date));
    }


    public static function parseHTTPQuery($input)
    {
        // convert http_query to key-value array
        $input = str_replace(".", ";;;", $input); // conserving dots
        parse_str( $input, $array);

        // replace underscores with spaces in each key-value pair and push pair into new array
        $parsedData = array();
        foreach ($array as $key => $value)
        {
            // if value is an array (as in case for a checkbox), replace each entry's underscores with spaces
            $newValue = (is_array($value)) ? trim(str_replace("_", " ", join(", ", array_keys($value)))) : trim(str_replace("_", " ", $value));
            $newKey = trim(str_replace("_", " ", $key));

            $parsedData[str_replace(";;;", ".", $newKey)] = str_replace(";;;", ".", $newValue); // reinstating dots
        }

        return $parsedData;
    }
}
