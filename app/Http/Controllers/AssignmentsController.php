<?php

namespace App\Http\Controllers;

use App\Assignments;
use App\Events;
use App\Helpers\QueryHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AssignmentsController extends Controller
{
    // show all assignments
    public function index()
    {
        return view('Manage/assignments', ['assignments' => Assignments::paginate(25)]);
    }


    // create assignment
    public function store(Request $request)
    {
        $validated = $request->validate([
            'events_id' => 'exists:events,id',
            'email' => 'nullable|email',
            'sites_id' => 'nullable|exists:sites,id'
        ]);

        Assignments::create($validated);
    }


    // update specified assignment
    public function update(Assignments $assignment)
    {

    }


    // delete specified assignment
    public function delete(Assignments $assignment)
    {
        Assignments::destroy($assignment->id);
        return redirect()->route('assignments');
    }


    // get all overdue assignments
    public function overdue(Request $request)
    {
        // get optional search filtering parameters
        $user = $request->filled('user') ? $request->user : null;
        $form = $request->filled('form') ? $request->form : null;
        $date_from = $request->filled('date_from') ? $request->date_from : null;
        $date_to = $request->filled('date_to') ? $request->date_to : null;

        $overdues = QueryHelper::getOverdues($user, $form, $date_from, $date_to);

        return view('Assignments/overdue', [
            'overdues' => $overdues,
            'user' => $user,
            'form' => $form,
            'date_from' => $date_from,
            'date_to' => $date_to
        ]);
    }

}
