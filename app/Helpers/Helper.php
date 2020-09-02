<?php


namespace App\Helpers;


use App\Submissions;
use Illuminate\Support\Facades\Auth;

class Helper
{
    public static function makeTimeStampReadable($timestamp)
    {
        return date('M d, Y @ H:i a', strtotime($timestamp));
    }


    public static function makeDateReadable($date)
    {
        return date('M d, Y', strtotime($date));
    }

    public static function filterEvents($events)
    {
        // if admin, return all events
        if (Auth::user()->isAdmin()) {

            return $events;
        }

        // if elementary principal, filter events for principals, all staff and elementary principals
        elseif (Auth::user()->isElementaryPrincipal()) {

            $events = $events->filter( function($value) {
                if ($value->forms->required_for == 'All Staff')
                    return true;
                if ($value->forms->required_for == 'Elementary Principals Only')
                    return true;
                if ($value->forms->required_for == 'Principals and Vice Principals')
                    return true;
            });
        }

        // if secondary principal, filter events for principals, all staff and secondary principals
        elseif (Auth::user()->isSecondaryPrincipal()) {

            $events = $events->filter( function($value, $key) {
                if ($value->forms->required_for == 'All Staff')
                    return true;
                if ($value->forms->required_for == 'Secondary Principals Only')
                    return true;
                if ($value->forms->required_for == 'Principals and Vice Principals')
                    return true;
            });
        }

        // if not principal, filter events for all staff
        else {
            $events = $events->filter( function($value, $key) {
                if ($value->forms->required_for == 'All Staff')
                    return true;
            });
        }

        return $events->values();
    }


    public static function filterEventsDashboard($events, $user)
    {
        // if admin, return all events
        if ($user->isAdmin()) {

            return $events;
        }

        // if elementary principal, filter events for principals, all staff and elementary principals
        elseif ($user->isElementaryPrincipal()) {

            $events = $events->filter( function($value) {
                if ($value->required_for == 'All Staff')
                    return true;
                if ($value->required_for == 'Elementary Principals Only')
                    return true;
                if ($value->required_for == 'Principals and Vice Principals')
                    return true;
            });
        }

        // if secondary principal, filter events for principals, all staff and secondary principals
        elseif ($user->isSecondaryPrincipal()) {

            $events = $events->filter( function($value, $key) {
                if ($value->required_for == 'All Staff')
                    return true;
                if ($value->required_for == 'Secondary Principals Only')
                    return true;
                if ($value->required_for == 'Principals and Vice Principals')
                    return true;
            });
        }

        // if not principal, filter events for all staff
        else {

            $events = $events->filter( function($value, $key) {
                if ($value->required_for == 'All Staff')
                    return true;
            });
        }

        return $events;
    }


    public static function parseHTTPQuery($input)
    {
        // convert http_query to key-value array
        parse_str($input, $data);

        // replace underscores with spaces in each key-value pair and push pair into new array
        $parsedData = array();
        foreach ($data as $key => $value)
        {
            // if value is an array (as in case for a checkbox), replace each entry's underscores with spaces
            $newValue = (is_array($value)) ? str_replace("_", " ", join(", ", array_keys($value))) : str_replace("_", " ", $value);
            $newKey = str_replace("_", " ", $key);

            $parsedData[$newKey] = $newValue;
        }

        return $parsedData;
    }
}
