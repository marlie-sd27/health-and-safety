<?php
// Copyright (c) Microsoft Corporation.
// Licensed under the MIT License.

namespace App\Http\Controllers;

use App\Events;
use App\Helpers\Helper;
use App\Submissions;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function dashboard()
    {

        // if user is admin
        if(Auth::user()->isAdmin())
        {
            // get all upcoming events
            $viewData['upcomings'] = Events::with('forms')
                ->where('date', '>', Carbon::now())
                ->where('date', '<', Carbon::now()->addMonths(3))
                ->orderBy('date', 'asc')
                ->limit(5)
                ->get();


            // get all overdue events for the user
            $viewData['overdues'] = Events::with('forms')
                ->where('date', '<', Carbon::now())
                ->whereNotIn('events.id', function($query) {
                    $query->select('events_id')
                        ->from('submissions')
                        ->where('email', Auth::user()->email)
                        ->get();
                })
                ->orderBy('date', 'asc')
                ->get();

            $viewData['overdues'] = Helper::filterEvents($viewData['overdues']);


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
                ->whereNotIn('events.id', function($query) {
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
                ->whereNotIn('events.id', function($query) {
                    $query->select('events_id')
                        ->from('submissions')
                        ->where('email', Auth::user()->email)
                        ->get();
                })
                ->orderBy('date', 'asc')
                ->get();

            $viewData['overdues'] = Helper::filterEvents($viewData['overdues']);


            // get all completed submissions for the user
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
