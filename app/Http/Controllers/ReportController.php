<?php

namespace App\Http\Controllers;

use App\Events;
use App\Forms;
use App\Sites;
use App\Submissions;
use App\TokenStore\TokenCache;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;
use Illuminate\Support\Facades\Response;

class ReportController extends Controller
{

    public function bySite(Request $request)
    {
        // get filter parameters
        $raw_site = $request->filled('site') ? $request->site : null;
        $raw_form = $request->filled('form') ? $request->form : null;
        $raw_deadline = $request->filled('deadline') ? $request->deadline : null;

        $site = $raw_site ? Sites::firstWhere('site', $raw_site) : null;
        $form = $raw_form ? Forms::firstWhere('title', $raw_form) : null;

        $event = $form && $raw_deadline ? Events::firstWhere([
            'forms_id' => $form->id,
            'date' => $raw_deadline,
        ]) : null;


        // if site and event don't exist, return to view with message saying select those things
        if (!$site || !$event || !$form) {
            return view('Report/bysite', [
                'users' => null,
                'submissions' => null,
                'event' => $event,
                'sites' => Sites::all(),
                'site' => $raw_site,
                'form' => $raw_form,
                'deadline' => $raw_deadline,
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
        $collection = collect($users->getResponseAsObject(Model\User::class))->sort();

        // gather all the email addresses from the users pulled
        $emails = new Collection();
        $collection->each(function ($item) use ($emails) {
            $emails->push($item->getMail());
        });

        // run a query to check who has submitted for that deadline
        $submissions = Submissions::whereIn('email', $emails)
            ->where('events_id', $event->id)
            ->pluck('id', 'email');

        $outstanding = $emails->diff($submissions->keys());
        return view('Report/bysite', [
            'users' => $collection,
            'submissions' => $submissions,
            'event' => $event,
            'sites' => Sites::all(),
            'site' => $site->site,
            'form' => $form->title,
            'deadline' => $event->date,
            'outstanding' => $outstanding->join(';'),
            'emails' => $emails->join(';'),
        ]);
    }


    public function export(Request $request)
    {
//        dd($this->collection);
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
        $callback = function () {
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
