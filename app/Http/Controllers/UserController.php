<?php

namespace App\Http\Controllers;


use App\Helpers\CollectionHelper;
use App\Helpers\GraphAPIHelper;
use App\TokenStore\TokenCache;
use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
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


        $users = session('users') ?? collect(GraphAPIHelper::getAllStaff());

        if ($name)
        {
            $users = $users->filter( function ($value, $key) {
                dd($value->getMail());
                return strpos($value->getMail(), 'marlie') !== false;
            });
        }

        session(['users' => $users]);

        return view('Manage/users', ['users' => CollectionHelper::paginate($users, 25), 'name' => $name]);
    }


    public function destroy(User $user)
    {
        User::destroy($user->id);
        return redirect()->route('users')->with('message', "Successfully deleted $user->name");
    }
}
