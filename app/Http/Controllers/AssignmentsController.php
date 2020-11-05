<?php

namespace App\Http\Controllers;

use App\Assignments;
use Illuminate\Http\Request;

class AssignmentsController extends Controller
{
    public function index()
    {
        return view('Manage/Assignments', ['assignments' => Assignments::all()]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'events_id' => 'exists:events,id',
            'email' => 'nullable|email',
            'sites_id' => 'nullable|exists:sites,id'
        ]);

        Assignments::create($validated);
    }


    public function update(Assignments $assignment)
    {

    }


    public function delete(Assignments $assignment)
    {
        Assignments::destroy($assignment->id);
        return redirect()->route('assignments');
    }


}
