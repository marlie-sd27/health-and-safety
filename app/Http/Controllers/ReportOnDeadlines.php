<?php

namespace App\Http\Controllers;

use App\Events;
use App\Forms;
use App\Sites;
use App\Submissions;
use App\TokenStore\TokenCache;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;
use Illuminate\Support\Facades\Response;

class ReportOnDeadlines extends Controller
{

    private $collection;

    public function __construct() {
        $this->collection = new Collection();
    }

    public function index(Request $request)
    {
        // get filter parameters
        $site = $request->filled('site') ? Sites::firstWhere('site', $request->site) : null;
        $form = $request->filled('form') ? Forms::firstWhere('title', $request->form) : null;
        $event = $request->filled('deadline') ? Events::firstWhere([
            ['date',$request->deadline],
            ['forms_id', $form->id]
        ]) : null;


        // check for valid site
        if (!$site)
        {
            $request->session()->flash('error', 'Please select a site');
            return view('ReportOnDeadlines/index', [
                'site' => $site ? $site->site : null,
                'sites' => Sites::all(),
                'form' => $form ? $form->title : null,
                'deadline' => $event ? $event->date : null,
                'event' => $event,
                ]);
        }

        // check for valid form
        if (!$form)
        {
            $request->session()->flash('error', 'Please select a form');
            return view('ReportOnDeadlines/index', [
                'site' => $site ? $site->site : null,
                'sites' => Sites::all(),
                'form' => $form ? $form->title : null,
                'deadline' => $event ? $event->date : null,
                'event' => $event,
            ]);
        }

        // check for valid deadline
        if (!$event)
        {
            $request->session()->flash('error', 'Please select a valid deadline for this form');
            return view('ReportOnDeadlines/index', [
                'site' => $site ? $site->site : null,
                'sites' => Sites::all(),
                'form' => $form ? $form->title : null,
                'deadline' => $event ? $event->date : null,
                'event' => $event,
            ]);
        }

        // build query to get user data
        $tokenCache = new TokenCache();

        $graph = new Graph();
        $graph->setAccessToken($tokenCache->getAccessToken());

        //build and execute query to pull group members for specified site
        $queryParams = array(
            '$select' => 'displayName,mail,jobTitle,department',
            '$top' => 999,
        );
        $getUsersUrl = "/groups/{$site->azure_group_id}/members?" . http_build_query($queryParams);

        $users = $graph->createRequest('GET', $getUsersUrl)
            ->execute();

        // convert users into a collection of Microsoft Graph Users
        $this->collection = collect($users->getResponseAsObject(Model\User::class))->sort();

        // gather all the email addresses from the users pulled
        $emails = new Collection();
        $this->collection->each(function ($item) use ($emails) {
            $emails->push($item->getMail());
        });

        // run a query to check who has submitted for that deadline
        $submissions = Submissions::whereIn('email', $emails)
            ->where('events_id', $event->id)
            ->pluck('email');


        return view('ReportOnDeadlines/index', [
            'users' => $this->collection,
            'submissions' => $submissions,
            'event' => $event,
            'sites' => Sites::all(),
            'site' => $site->site,
            'form' => $form,
            'deadline' => $event->date,
        ]);
    }


    public function export(Request $request)
    {
        dd($this->collection);
        // prepare export
        $filename = $request->form . "_" . $request->site . "_" . Carbon::now() . ".csv";
        $headers = [
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$filename",
            'Expires' => '0',
            'Pragma' => 'public'
        ];

        // if there is no data, return nessage that there is nothing to export
//        if(!$list){
//            return redirect()->back()->with('error', 'Nothing to export');
//        }

        // add headers for each column in the CSV download
        array_unshift($this->collection->toArray(), ['1', '2', '3', '4', '5']);

        // write data to csv
        $callback = function()
        {
            $FH = fopen('php://output', 'w');
            foreach ($this->collection as $row) {
                fputcsv($FH, $row);
            }
            fclose($FH);
        };

        // return csv as a downloadable
        return Response::stream($callback, 200, $headers);
    }
}
