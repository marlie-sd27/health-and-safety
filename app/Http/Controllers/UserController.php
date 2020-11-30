<?php

namespace App\Http\Controllers;


use App\Helpers\CollectionHelper;
use App\Helpers\GraphAPIHelper;
use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    use SoftDeletes;

    public function profile()
    {
        return view('Users/profile');
    }

    public function index(Request $request)
    {
        // get the optional search parameter
        $name = $request->filled('name') ? strtolower($request->name) : null;

        // check if users is stored in session. If not, send request to Azure and get all staff.
        // Store in collection for easier use of methods (ex, filter, paginate, sort)
        $users = session('users') ?? collect(GraphAPIHelper::getAllStaff());

        // set session variable users for loading users more efficiently with further requests
        session(['users' => $users]);


        // if name parameter is set, filter users by name
        if($name)
        {
            $users = $users->filter(function ($value) use ($name) {
                // if mail address exists for user, check if it contains the name search parameter to filter
                if($value->getMail())
                {
                    return str_contains(strtolower($value->getMail()), $name);
                } else return false;
            });
        }

        return view('Manage/users', ['users' => CollectionHelper::paginate($users, 25), 'name' => $name]);
    }


    public function destroy(User $user)
    {
        User::destroy($user->id);
        return redirect()->route('users')->with('message', "Successfully deleted $user->name");
    }
}
