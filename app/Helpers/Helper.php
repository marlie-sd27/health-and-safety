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
        if (!Auth::user()->isPrincipal()) {
            return $events->where('forms.required_for', 'All Staff');
        } else return $events;
    }
}
