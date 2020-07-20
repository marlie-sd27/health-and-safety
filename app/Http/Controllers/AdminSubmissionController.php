<?php

namespace App\Http\Controllers;

use App\Submissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminSubmissionController extends Controller
{
    // show all submissions for logged in user
    public function index(Request $request)
    {
        return view('Submissions.index', ['submissions' => Submissions::with('forms')->get()]);
    }
}
