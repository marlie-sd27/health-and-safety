<?php


namespace App\Helpers;


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
        if (Auth::user()->isElementaryPrincipal()) {

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
        if (Auth::user()->isSecondaryPrincipal()) {

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
        if (!Auth::user()->isPrincipal()) {

            $events = $events->filter( function($value, $key) {
                return $value->forms->required_for == 'All Staff';
            });
        }

        return $events;
    }
}
