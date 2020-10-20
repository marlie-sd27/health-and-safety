<?php

namespace App\Http\Controllers;

use App\Events;
use App\Submissions;
use App\TokenStore\TokenCache;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;

class ReportOnDeadlines extends Controller
{
    public function index(Request $request)
    {
        // build query to get user data
        $tokenCache = new TokenCache();

        $graph = new Graph();
        $graph->setAccessToken($tokenCache->getAccessToken());

        //build and execute query to pull group members

        $queryParams = array(
            '$select' => 'displayName,mail,jobTitle,department',
            '$top' => 999,
        );
        $getUsersUrl = '/groups/{7129f052-d91d-4db7-8a73-d44b8b4bf7aa}/members?' . http_build_query($queryParams);

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
            ->where('events_id', 69)
            ->pluck('email');


        return view('Users/index', [
            'users' => $collection,
            'next' => $users->getNextLink(),
            'submissions' => $submissions,
            'event' => Events::find(69),
        ]);
    }
}
