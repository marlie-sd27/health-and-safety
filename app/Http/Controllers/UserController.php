<?php

namespace App\Http\Controllers;

use App\Events;
use App\Submissions;
use App\TokenStore\TokenCache;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;

class UserController extends Controller
{
    use SoftDeletes;

    public function profile()
    {
        return view('Users/profile');
    }

    public function index(Request $request)
    {
        $name = $request->filled('name') ? $request->name : null;

        // filter query by user
        $users = User::when($name, function ($query, $name) {
            return $query->where('name', 'like', '%' . $name . '%')
                ->orWhere('email', 'like', '%'.$name.'%');
        })
            ->orderBy('name')
            ->paginate(20);

        return view('Manage/users', ['users' => $users, 'name'=>$name]);
    }


    public function destroy(User $user)
    {
        User::destroy($user->id);
        return redirect()->route('users')->with('message',"Successfully deleted $user->name");
    }


    public function retrieveUsersBySite(Request $request)
    {
        // build query to get user data
        $tokenCache = new TokenCache();

        $graph = new Graph();
        $graph->setAccessToken($tokenCache->getAccessToken());


        // check to see if there is a next link to query
        $next = $request->filled('next') ? $request->next : null;
        if ($next)
        {
            $users = $graph->createRequest('GET', $next)
                ->execute();

        }

        // otherwise build and execute query to pull group members
        else {

            $queryParams = array(
                '$select' => 'displayName,mail,jobTitle,department',
                '$top' => 999,
            );
            $getUsersUrl = '/groups/{7129f052-d91d-4db7-8a73-d44b8b4bf7aa}/members?'.http_build_query($queryParams);

            $users = $graph->createRequest('GET', $getUsersUrl)
                ->execute();
        }

        // convert users into a collection of Microsoft Graph Users
        $collection = collect($users->getResponseAsObject(Model\User::class));

        // gather all the email addresses from the users pulled
        $emails = new Collection();
        $collection->each( function ($item) use ($emails) {
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
