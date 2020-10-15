<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('Manage/admins', ['admins' => User::where('admin', true)->get()]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'email'
        ]);

        $admin = User::updateOrcreate(
            ['email' => $validated['email']],
            ['admin' => true, 'last_login' => Carbon::now()]
        );

        return redirect(route('admins'))->with(['message' => "Successfully added $admin->email as an admin"]);
    }


    public function destroy(User $admin)
    {
        $admin->update([
            'admin' => false,
        ]);

        return redirect(route('admins'))->with(['message' => "Successfully removed $admin->email from admin"]);
    }
}
