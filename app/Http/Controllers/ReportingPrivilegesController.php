<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportingPrivilegesController extends Controller
{

    public function index()
    {
        return view('Manage/report_access', [
            'users' => User::where('report_access', true)->orderBy('email')->get()
        ]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'string|required'
        ]);

        User::updateOrcreate(
            ['email' => $validated['email']],
            [
                'report_access' => true,
                'last_login' => Carbon::now()
            ]
        );

        return redirect()->route('reporters');
    }


    public function destroy(User $user)
    {
        $user->update([
            'report_access' => false,
        ]);
        return redirect()->route('reporters');
    }
}
