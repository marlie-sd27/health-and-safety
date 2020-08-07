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
        $date_from = $request->filled('date_from') ? $request->date_from : null;
        $date_to = $request->filled('date_to') ? $request->date_to : null;

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
            ->when( $date_from, function ($query, $date_from) {
                return $query->where('submissions.created_at', '>', $date_from );
            })
            ->when( $date_to, function ($query, $date_to) {
                return $query->where('submissions.created_at', '<', $date_to);
            })
            ->orderBy('submissions.created_at', 'desc')
            ->select('submissions.*','users.name','forms.title')
            ->get();

        return view('Admin/report', [
            'submissions' => $submissions,
            'user' => $user,
            'site' => $site,
            'form' => $form,
            'date_from' => $date_from,
            'date_to' => $date_to
        ]);
    }


    public function formReport(Forms $form)
    {
        return view('Admin/formReport');
    }
}
