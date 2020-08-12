<?php

namespace App\Http\Controllers;

use App\Events;
use App\Forms;
use App\Helpers\Helper;
use App\Submissions;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function report(Request $request)
    {
        $user = $request->filled('user') ? $request->user : null;
        $site = $request->filled('site') ? $request->site : null;
        $form = $request->filled('form') ? $request->form : null;
        $date_from = $request->filled('date_from') ? $request->date_from : null;
        $date_to = $request->filled('date_to') ? $request->date_to : null;

        $submissions = Submissions::join('forms', 'forms_id', '=', 'forms.id')
            ->join('users', 'submissions.email', '=', 'users.email')
            ->when($user, function ($query, $user) {
                return $query->where('users.name', 'like', '%' . $user . '%');
            })
            ->when($site, function ($query, $site) {
                return $query->where('site', 'like', '%' . $site . '%');
            })
            ->when($form, function ($query, $form) {
                return $query->where('title', 'like', '%' . $form . '%');
            })
            ->when($date_from, function ($query, $date_from) {
                return $query->where('submissions.created_at', '>', $date_from);
            })
            ->when($date_to, function ($query, $date_to) {
                return $query->where('submissions.created_at', '<', $date_to);
            })
            ->orderBy('submissions.created_at', 'desc')
            ->select('submissions.*', 'users.name', 'forms.title')
            ->get();

        return view('Admin/report', [
            'submissions' => $submissions,
            'user' => $user,
            'site' => $site,
            'form' => $form,
            'date_from' => $date_from,
            'date_to' => $date_to
        ]);
    }


    public function overdue(Request $request)
    {
        $overdues = array();

        // for each user, get all the overdue submissions (with form and event info)
        foreach (User::all() as $user) {
            $overdue = DB::select(DB::raw(
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
            $overdue = Helper::filterEventsDashboard(collect($overdue), $user);

            // push the user's overdues to the array with their name as the index
            $overdues[$user->name] = $overdue;
        }

        // get all the search parameters from the request if filled
        $user = $request->filled('user') ? $request->user : null;
        $form = $request->filled('form') ? $request->form : null;
        $date_from = $request->filled('date_from') ? $request->date_from : null;
        $date_to = $request->filled('date_to') ? $request->date_to : null;

        // convert our array of users' overdue submissions into an Eloquent collection for easy filtering
        // filter by user's search parameters
        $overdues = collect($overdues)

            // filter out users with no overdue events
            ->filter(function ($instance) {
                return sizeof($instance) > 0;
            })

            // when the user search parameter is filled, filter out collections whose key is not the user
            ->when($user, function ($collection, $user) {
                return $collection->filter(function ($value, $key) use ($user) {
                    return strstr($key, $user) != false;
                });

            })
            // when the form search parameter is filled, filter out instances who's title value is not the form
            ->when($form, function ($collection, $form) {
                return $collection->map(function( $instance ) use ($form) {
                    return $instance->filter(function ($value) use ($form) {
                        return strstr($value->title, $form) != false;
                    });
                });
            })
            //
            ->when( $date_from, function ($collection, $date_from) {
                return $collection->map(function( $instance ) use ($date_from) {
                    return $instance->filter(function ($value) use ($date_from) {
                        return $value->date >= $date_from;
                    });
                });
            })
            ->when( $date_to, function ($collection, $date_to) {
                return $collection->map(function( $instance ) use ($date_to) {
                    return $instance->filter(function ($value) use ($date_to) {
                        return $value->date <= $date_to;
                    });
                });
            });

        return view('Admin/overdue', [
            'overdues' => $overdues,
            'user' => $user,
            'form' => $form,
            'date_from' => $date_from,
            'date_to' => $date_to
        ]);
    }


    public function upcoming(Request $request)
    {
        // get all upcoming events
        $upcomings = Events::with('forms')
            ->where('date', '>', Carbon::now())
            ->where('date', '<', Carbon::now()->addMonths(3))
            ->orderBy('date', 'asc')
            ->get();

        return view('Admin/upcoming', ['upcomings' => $upcomings]);
    }
}
