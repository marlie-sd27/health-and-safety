<?php

namespace App\Http\Controllers;

use App\TokenStore\TokenCache;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
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

        } else {

            $queryParams = array(
                '$select' => 'displayName,mail,jobTitle,department',
                '$top' => 999,
            );
            $getUsersUrl = '/groups/{7129f052-d91d-4db7-8a73-d44b8b4bf7aa}/members?'.http_build_query($queryParams);

            $users = $graph->createRequest('GET', $getUsersUrl)
                ->execute();
        }

        return view('Users/index', [
            'users' => collect($users->getResponseAsObject(Model\User::class))->sort(),
            'next' => $users->getNextLink(),
        ]);
    }
}
