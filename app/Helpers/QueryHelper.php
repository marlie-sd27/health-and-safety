<?php


namespace App\Helpers;


use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class QueryHelper
{

    public static function getOverdues($user)
    {
        $overdues =  DB::select(DB::raw(
            'SELECT e.*, f.title, f.required_for ' .
            "FROM events e " .
            "JOIN forms f ON f.id = e.forms_id " .

            // get only overdue events
            "WHERE e.date < :now " .

            // filter events by only taking events that don't have an entry in the user's submissions
            "AND NOT EXISTS " .
            "(SELECT null FROM submissions s " .
            "WHERE e.id = s.events_id " .
            "AND s.email = :user) "),
            array(
                'now' => Carbon::now(),
                'user' => $user->email,
            )
        );

        // filter events to make sure only events applicable to the user's group apply
        // ie. an elementary principal shouldn't be getting a secondary principal's events
        return Helper::filterEventsDashboard(collect($overdues), $user);
    }
}
