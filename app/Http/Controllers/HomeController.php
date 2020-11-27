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

            // get the first 5 upcoming events in the next 4 months
            $viewData['upcomings'] = Events::with('forms')
                ->where('date', '>', Carbon::now())
                ->where('date', '<', Carbon::now()->addMonths(4))
                ->orderBy('date', 'asc')
                ->limit(5)
                ->get();


            // get first 5 overdue events for all users
            $viewData['overdues'] = Events::with('forms')
                ->join('assignments', 'assignments.events_id', '=', 'events.id')
                ->where('date', '<', Carbon::now())
                ->whereNotNull('assignments.email')
                ->whereNotIn('events.id', function ($query) {
                    $query->select('events_id')
                        ->from('submissions')
                        ->where('email', Auth::user()->email)
                        ->whereNotNull('events_id')
                        ->get();
                })
                ->orderBy('date', 'asc')
                ->limit(5)
                ->select('events.*','assignments.email','assignments.sites_id')
                ->get();


            // get all recent submissions
            $viewData['recents'] = Submissions::with('forms')
                ->where('created_at', '<', Carbon::now())
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            return view('Admin/dashboard', $viewData);
        }

        // if not an admin, get events for the user
        else {
            // get all relevant upcoming events in the next 4 months for the user that they haven't made a submission for
            $viewData['upcomings'] = Events::with('forms')
                ->join('assignments', 'assignments.events_id', '=', 'events.id')
                ->where('assignments.email', Auth::user()->email)
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
                ->select('events.*')
                ->get();


            // get all overdue events for the user
            $viewData['overdues'] = Events::with('forms')
                ->join('assignments', 'assignments.events_id', '=', 'events.id')
                ->where('assignments.email', Auth::user()->email)
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
                ->select('events.*')
                ->get();


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
