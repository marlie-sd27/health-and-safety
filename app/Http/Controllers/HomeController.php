<?php
// Copyright (c) Microsoft Corporation.
// Licensed under the MIT License.

namespace App\Http\Controllers;

use App\Events;
use App\Helpers\Helper;
use App\Helpers\QueryHelper;
use App\Helpers\ReportHelper;
use App\Submissions;
use App\User;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Query;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function dashboard()
    {
        // if user is admin...
        if (Auth::user()->isAdmin() || Auth::user()->isReporter())
        {
            return $this->adminDashboard();
        }

        // if user is a principal...
        else if(Auth::user()->isPrincipal())
        {
            return $this->principalDashboard();
        }

        // if not an admin or principal...
        else {
            return $this->staffDashboard();
        }

    }


    // populate and return admin dashboard
    private function adminDashboard()
    {
        // get the first 5 upcoming events in the next 4 months
        $viewData['upcomings'] = Events::with('forms')
            ->where('date', '>', Carbon::now())
            ->where('date', '<', Carbon::now()->addMonths(4))
            ->orderBy('date', 'asc')
            ->limit(5)
            ->get();


        // get first 5 overdue events
        $viewData['overdues'] = QueryHelper::getOverdues()->take(5);

        // get all recent submissions
        $viewData['recents'] = Submissions::with('forms')
            ->where('created_at', '<', Carbon::now())
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('Admin/dashboard', $viewData);
    }


    // populate and return principal dashboard
    private function principalDashboard()
    {
        // get first 5 completed submissions for the user
        $viewData['completeds'] = Submissions::with(['forms', 'sites'])
            ->where('email', Auth::user()->email)
            ->orWhere('submissions.sites_id', Auth::user()->getSites_id())
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();


        // get all relevant upcoming events in the next 4 months for the user that they haven't made a submission for
        $upcomings = Events::with('forms')
            ->join('assignments', 'assignments.events_id', '=', 'events.id')
            ->where( function($query) {
                $query->where('assignments.email', Auth::user()->email)
                    ->orWhere('assignments.sites_id', Auth::user()->getSites_id());
            })
            ->where('date', '>=', Carbon::now())
            ->where('date', '<', Carbon::now()->addMonths(4))
            ->orderBy('date', 'asc')
            ->limit(5)
            ->select('events.*')
            ->get();


        $viewData['upcomings'] = $upcomings->filter( function($upcoming) use ($viewData) {
            return !in_array($upcoming->id, $viewData['completeds']->pluck('events_id')->toArray());
        });


        // get all overdue events for the user and their site
        $overdues = QueryHelper::getOverdues(null,null,null,null,null,null,null,null);
        $viewData['overdues'] = $overdues->filter( function($overdue) {
            return $overdue->email === Auth::user()->email || $overdue->code === Auth::user()->site;
        })->take(5);


        return view('dashboard', $viewData);
    }


    // populate and return staffDashboard
    private function staffDashboard()
    {
        // get first 5 completed submissions for the user
        $viewData['completeds'] = Submissions::with(['forms','sites'])
            ->where('email', Auth::user()->email)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();


        // get all relevant upcoming events in the next 4 months for the user that they haven't made a submission for
        $upcomings = Events::with('forms')
            ->join('assignments', 'assignments.events_id', '=', 'events.id')
            ->where('assignments.email', Auth::user()->email)
            ->where('date', '>=', Carbon::now())
            ->where('date', '<', Carbon::now()->addMonths(4))
            ->orderBy('date', 'asc')
            ->limit(5)
            ->select('events.*')
            ->get();


        $viewData['upcomings'] = $upcomings->filter( function($upcoming) use ($viewData) {
            return !in_array($upcoming->id, $viewData['completeds']->pluck('events_id')->toArray());
        });

        // get all overdue events for the user
        $viewData['overdues'] = QueryHelper::getOverdues(Auth::user()->email)->take(5);


        return view('dashboard', $viewData);
    }


    public function welcome()
    {
        return view('welcome');
    }


}
