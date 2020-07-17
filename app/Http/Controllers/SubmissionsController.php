<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubmission;
use App\Submissions;
use Illuminate\Http\Request;
use App\Helpers\Helper;

class SubmissionsController extends Controller
{

    // show all submissions
    public function index(Request $request)
    {
        $user = $request->user ?? null;
        $form = $request->form ?? null;

        return view('Submissions.index', ['submissions' => Submissions::with('forms')->get()]);
    }


    // store the newly created submission in the database
    public function store(StoreSubmission $validated)
    {
        Submissions::create([
            'forms_id' => $validated->form_id,
            'username' => $this->viewData['userName'],
            'email' => $this->viewData['userEmail'],
            'data' => $validated->data,
        ]);

        return redirect(route('submissions.index'))->with('message', "Submission successful!");
    }


    // show a submission
    public function show(Submissions $submission)
    {
        return view('Submissions/show', ['submission' => $submission->prepareSubmission()]);
    }


    // show form for editing submission
    public function edit(Submissions $submission)
    {
        return view('Submissions/edit', ['submission' => $submission->prepareSubmission()]);
    }


    // update submission in the database
    public function update(StoreSubmission $validated, Submissions $submission)
    {
        $submission->update([
            'data' => $validated->data,
        ]);
        $submission->save();

        return redirect(route('submissions.show', ['submission' => $submission]))->with('message', 'Successfully updated submission');
    }


    // delete submission
    public function destroy(Submissions $submission)
    {
        Submissions::destroy($submission->id);
        return redirect(route('submissions.index'))->with('message', 'Successfully deleted submission!');
    }
}
