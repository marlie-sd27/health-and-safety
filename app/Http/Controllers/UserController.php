<?php

namespace App\Http\Controllers;


use App\TokenStore\TokenCache;
use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;
use Illuminate\Support\Facades\Response;

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
                ->orWhere('email', 'like', '%' . $name . '%');
        })
            ->orderBy('name')
            ->paginate(20);

        return view('Manage/users', ['users' => $users, 'name' => $name]);
    }


    public function destroy(User $user)
    {
        User::destroy($user->id);
        return redirect()->route('users')->with('message', "Successfully deleted $user->name");
    }


    public function groups()
    {
        // build query to get user data
        $tokenCache = new TokenCache();

        $graph = new Graph();
        $graph->setAccessToken($tokenCache->getAccessToken());


        //build and execute query to pull group members for specified site
        $queryParams = array(
            '$top' => 100,
        );
        $getUsersUrl = "/groups?" . http_build_query($queryParams);

        $response = $graph->createRequest('GET', $getUsersUrl)
            ->execute();

        $groups = $response->getResponseAsObject(Model\Group::class);


        $smallGroups = $this->getSmallGroups($groups, $graph, collect());

        return [$response->getNextLink(), $smallGroups];

        while ($response->getNextLink() != null) {
            $response = $graph->createRequest('GET', $response->getNextLink())
                ->execute();
            $groups = $response->getResponseAsObject(Model\Group::class);
            $smallGroups = $this->getSmallGroups($groups, $graph, $smallGroups);
        }


    }


    public function getSmallGroups($groups, $graph, $smallGroups)
    {
        foreach ($groups as $group) {
            if (!strpos($group->getDisplayName(), 'ipad')) {
                if (!strpos($group->getDisplayName(), 'staff')) {
                    $members = $graph->createRequest('GET', "/groups/{$group->getId()}/members")
                        ->execute()
                        ->getResponseAsObject(Model\User::class);
                    if (sizeof($members) <= 3) {
                        $smallGroups->push([$group->getDisplayName() => sizeof($members)]);
                    }
                }
            }

        }
        return $smallGroups;

    }
}
