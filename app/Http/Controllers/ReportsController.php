<?php

namespace App\Http\Controllers;

use App\Forms;
use App\Submissions;
use App\User;
use Illuminate\Support\Facades\Auth;

class ReportsController extends Controller
{
    public function userReport()
    {
        return view('Admin/usersReport', ['submissions' => Submissions::with('forms')->orderBy('created_at', 'desc')->get()]);
    }


    public function formReport(Forms $form)
    {
        return view('Admin/formReport');
    }
}
