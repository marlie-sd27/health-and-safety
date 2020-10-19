<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
