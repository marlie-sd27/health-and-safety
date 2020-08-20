<?php

namespace App\Http\Controllers;

use App\Events;
use App\Forms;
use App\Helpers\Helper;
use App\Helpers\ReportHelper;
use App\Submissions;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class ReportsController extends Controller
{
    public function report(Request $request)
    {
        $user = $request->filled('user') ? $request->user : null;
        $site = $request->filled('site') ? $request->site : null;
        $form = $request->filled('form') ? $request->form : null;
        $date_from = $request->filled('date_from') ? $request->date_from : null;
        $date_to = $request->filled('date_to') ? $request->date_to : null;

       $submissions = ReportHelper::generateReport($request, $user, $site, $form, $date_from, $date_to);

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

        $overdues = ReportHelper::filterOverdues($overdues, $user, $form, $date_from, $date_to);

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


    // export report as csv
    public function export(Request $request)
    {
        $headers = [
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=report.csv',
            'Expires' => '0',
            'Pragma' => 'public'
        ];

        $user = $request->filled('user') ? $request->user : null;
        $site = $request->filled('site') ? $request->site : null;
        $form = $request->filled('form') ? $request->form : null;
        $date_from = $request->filled('date_from') ? $request->date_from : null;
        $date_to = $request->filled('date_to') ? $request->date_to : null;

        $list = ReportHelper::generateReport($request, $user, $site, $form, $date_from, $date_to)->toArray();

        # add headers for each column in the CSV download
        array_unshift($list, array_keys($list[0]));

        $callback = function() use ($list)
        {
            $FH = fopen('php://output', 'w');
            foreach ($list as $row) {
                fputcsv($FH, $row);
            }
            fclose($FH);
        };

        return Response::stream($callback, 200, $headers);
    }
}
