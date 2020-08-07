<?php

namespace App\Http\Controllers;

use App\Forms;
use App\Submissions;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function report(Request $request)
    {
        $user = $request->filled('user') ? $request->user : null;
        $site = $request->filled('site') ? $request->site : null;
        $form = $request->filled('form') ? $request->form : null;

        $submissions = Submissions::join('forms', 'forms_id', '=', 'forms.id')
            ->join('users', 'submissions.email', '=', 'users.email')
            ->when( $user, function ($query, $user) {
                return $query->where('users.name', 'like', '%' . $user . '%');
            })
            ->when( $site, function ($query, $site) {
                return $query->where('site', 'like', '%' . $site . '%');
            })
            ->when( $form, function ($query, $form) {
                return $query->where('title', 'like', '%' . $form . '%');
            })
            ->orderBy('submissions.created_at', 'desc')
            ->get();

        return view('Admin/report', ['submissions' => $submissions, 'user' => $user, 'site' => $site, 'form'=>$form]);
    }


    public function formReport(Forms $form)
    {
        return view('Admin/formReport');
    }
}
