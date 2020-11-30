<?php


namespace App\Helpers;


use App\Events;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class QueryHelper
{

    public static function getOverdues($user = null, $form = null, $date_from = null, $date_to = null, $paginate = 25)
    {
        // get first 5 overdue events
        return Events::join('forms', 'events.forms_id', '=', 'forms.id')
            ->join('assignments', 'assignments.events_id', '=', 'events.id')
            ->where('date', '<', Carbon::now())
            ->whereNotNull('assignments.email')
            ->whereNotIn('assignments.id', function ($query) {
                $query->from('events')
                    ->join('submissions', 'events.id', '=', 'submissions.events_id')
                    ->join('assignments', 'events.id', '=', 'assignments.events_id')
                    ->whereNotNull('assignments.email')
                    ->whereColumn('submissions.email', '=', 'assignments.email')
//                    ->orWhereColumn('submissions.site', '=', 'assignments.sites_id')
                    ->select('assignments.id')
                    ->get();
            })
            // when the user search parameter is filled, filter out collections whose key is not the user
            ->when($user, function ($query, $user) {
                return $query->where('assignments.email', 'like', '%' . $user . '%');
            })
            // when the form search parameter is filled, filter out instances who's title value is not the form
            ->when($form, function ($query, $form) {
                return $query->where('forms.title', $form);
            })
            //
            ->when($date_from, function ($query, $date_from) {
                return $query->where('events.date', '>=', $date_from);
            })
            ->when($date_to, function ($query, $date_to) {
                return $query->where('events.date', '<=', $date_to);
            })
            ->orderBy('date', 'asc')
            ->select('events.*', 'assignments.email', 'forms.title')
            ->paginate($paginate, ['*'], 'overdue');
    }


    // get all completed submissions
    public static function getCompleted($user = null, $form = null, $date_from = null, $date_to = null, $deadline = null, $site = null, $paginate = 25)
    {
        return Events::join('submissions', 'events.id', '=', 'submissions.events_id')
            ->join('assignments', 'events.id', '=', 'assignments.events_id')
            ->join('forms', 'events.forms_id', '=', 'forms.id')
            ->whereNotNull('assignments.email')
            ->whereColumn('submissions.email', '=', 'assignments.email')

            // when the user search parameter is filled, filter out collections whose key is not the user
            ->when($user, function ($query, $user) {
                return $query->where('submissions.email', 'like', '%' . $user . '%');
            })
            // when the form search parameter is filled, filter out instances who's title value is not the form
            ->when($form, function ($query, $form) {
                return $query->where('forms.title', $form);
            })
            //
            ->when($date_from, function ($query, $date_from) {
                return $query->where('events.date', '>=', $date_from);
            })
            ->when($date_to, function ($query, $date_to) {
                return $query->where('events.date', '<=', $date_to);
            })
            ->when($deadline, function ($query, $deadline) {
                return $query->where('events.id', $deadline);
            })
            ->when($site, function ($query, $site) {
                return $query->where('submissions.site', $site);
            })
            ->orderBy('date', 'asc')
            ->select('events.date', 'assignments.email','forms.title', 'submissions.id')
            ->paginate($paginate, ['*'], 'completed');
    }
}
