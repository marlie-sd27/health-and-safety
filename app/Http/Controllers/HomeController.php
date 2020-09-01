<?php
// Copyright (c) Microsoft Corporation.
// Licensed under the MIT License.

namespace App\Http\Controllers;

use App\Events;
use App\Helpers\Helper;
use App\Submissions;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function dashboard()
    {

        // if user is admin
        if (Auth::user()->isAdmin()) {

            // get the first 5 upcoming events in the next 3 months
            $viewData['upcomings'] = Events::with('forms')
                ->where('date', '>', Carbon::now())
                ->where('date', '<', Carbon::now()->addMonths(3))
                ->orderBy('date', 'asc')
                ->limit(5)
                ->get();


            // get first 5 overdue events for all users
            $viewData['overdues'] = array();

            // for each user, get all the overdue submissions (with form and event info)
            foreach (User::all() as $user) {
                $overdues = DB::select(DB::raw(
                    'SELECT e.*, f.title, f.required_for ' .
                    "FROM events e " .
                    "JOIN forms f ON f.id = e.forms_id " .

                    // get only overdue events
                    "WHERE e.date < :now " .

                    // filter events by only taking events that don't have an entry in the user's submissions
                    "AND NOT EXISTS " .
                    "(SELECT null FROM submissions s " .
                    "WHERE e.id = s.events_id " .
                    "AND s.email = :user) " .
                    "LIMIT 1 "),
                    array(
                        'now' => Carbon::now(),
                        'user' => $user->email,
                    )
                );

                // filter events to make sure only events applicable to the user's group apply
                // ie. an elementary principal shouldn't be getting a secondary principal's events
                $overdues = Helper::filterEventsDashboard(collect($overdues), $user);

                // push the user's overdues to the array with their name as the index
                $viewData['overdues'][$user->name] = $overdues;
            }

            // convert our array of users' overdue submissions into an Eloquent collection for easy filtering
            $viewData['overdues'] = collect($viewData['overdues'])

                // filter out users with no overdue events
                ->filter( function( $value, $key) {
                    return sizeof($value) > 0;
                })

                // only take the first 5 overdues to report on the dashboard
                ->slice(0,5);



            // get all recent submissions
            $viewData['recents'] = Submissions::with('forms')
                ->where('created_at', '<', Carbon::now())
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            return view('Admin/dashboard', $viewData);

            // otherwise
        } else {
            // get all relevant upcoming events for the user that they haven't made a submission for
            $viewData['upcomings'] = Events::with('forms')
                ->where('date', '>=', Carbon::now())
                ->where('date', '<', Carbon::now()->addMonths(4))
                ->whereNotIn('events.id', function ($query) {
                    $query->select('events_id')
                        ->from('submissions')
                        ->where('email', Auth::user()->email)
                        ->get();
                })
                ->orderBy('date', 'asc')
                ->limit(5)
                ->get();

            $viewData['upcomings'] = Helper::filterEvents($viewData['upcomings']);


            // get all overdue events for the user
            $viewData['overdues'] = Events::with('forms')
                ->where('date', '<', Carbon::now())
                ->whereNotIn('events.id', function ($query) {
                    $query->select('events_id')
                        ->from('submissions')
                        ->where('email', Auth::user()->email)
                        ->whereNotNull('events_id')
                        ->get();
                })
                ->orderBy('date', 'asc')
                ->limit(5)
                ->get();

            $viewData['overdues'] = Helper::filterEvents($viewData['overdues']);


            // get first 5 completed submissions for the user
            $viewData['completeds'] = Submissions::with('forms')
                ->where('email', Auth::user()->email)
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            return view('dashboard', $viewData);
        }


    }

    public function welcome()
    {
        return view('welcome');
    }


}
