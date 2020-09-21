<?php

namespace App\Http\Controllers;

use App\Events;
use App\Helpers\QueryHelper;
use App\Helpers\ReportHelper;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
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

       $submissions = ReportHelper::generateReport($user, $site, $form, $date_from, $date_to);

        return view('Report/report', [
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
            $overdue = QueryHelper::getOverdues($user);

            // push the user's overdues to the array with their name as the index
            $overdues[$user->name] = $overdue;
        }

        // get all the search parameters from the request if filled
        $user = $request->filled('user') ? $request->user : null;
        $form = $request->filled('form') ? $request->form : null;
        $date_from = $request->filled('date_from') ? $request->date_from : null;
        $date_to = $request->filled('date_to') ? $request->date_to : null;

        $overdues = ReportHelper::filterOverdues($overdues, $user, $form, $date_from, $date_to);

        return view('Report/overdue', [
            'overdues' => $overdues,
            'user' => $user,
            'form' => $form,
            'date_from' => $date_from,
            'date_to' => $date_to
        ]);
    }


    public function upcoming()
    {
        // get all upcoming events
        $upcomings = Events::with('forms')
            ->where('date', '>', Carbon::now())
            ->where('date', '<', Carbon::now()->addMonths(6))
            ->orderBy('date', 'asc')
            ->get();

        return view('Report/upcoming', ['upcomings' => $upcomings]);
    }


    // export report as csv
    public function export(Request $request)
    {
        $form = $request->filled('form') ? $request->form : null;
        $site = $request->filled('site') ? $request->site : null;
        $user = $request->filled('user') ? $request->user : null;
        $date_from = $request->filled('date_from') ? $request->date_from : null;
        $date_to = $request->filled('date_to') ? $request->date_to : null;

        if (!$form)
        {
            return redirect(route('report'))->with('error','Exports are only available when a form is specified in the search parameters');
        }

        $filename = $form . "_" . Carbon::now() . ".csv";
        $headers = [
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$filename",
            'Expires' => '0',
            'Pragma' => 'public'
        ];

        $list = ReportHelper::generateReport( $user, $site, $form, $date_from, $date_to);
        $list = ReportHelper::prepareData($list)->toArray();

        if(!$list){
            return redirect()->back()->with('error', 'Nothing to export');
        }

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
