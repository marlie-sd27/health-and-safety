<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubmission;
use App\Submissions;
use Illuminate\Support\Facades\Auth;

class SubmissionsController extends Controller
{

    // show all submissions for logged in user
    public function index()
    {
        return view('Submissions.index', [
            'submissions' => Submissions::with('forms')
                ->where('email', '=',Auth::user()->email)
                ->get()
        ]);
    }


    // store the newly created submission in the database
    public function store(StoreSubmission $validated)
    {
        Submissions::create([
            'forms_id' => $validated->form_id,
            'username' => Auth::user()->name,
            'email' => Auth::user()->email,
            'data' => $validated->data,
        ]);

        return redirect(route('submissions.index'))
            ->with('message', "Submission successful!");
    }


    // show a submission
    public function show(Submissions $submission)
    {
        $this->authorize('view', $submission);
//        dd($submission->prepareSubmission());
        return view('Submissions/show', ['submission' => $submission->prepareSubmission()]);
    }


    // show form for editing submission
    public function edit(Submissions $submission)
    {
        $this->authorize('update', $submission);
//        dd($submission->prepareSubmission());
        return view('Submissions/edit', ['submission' => $submission->prepareSubmission()]);
    }


    // update submission in the database
    public function update(StoreSubmission $validated, Submissions $submission)
    {
        $this->authorize('update', $submission);

        $submission->update([
            'data' => $validated->data,
        ]);
        $submission->save();

        return redirect(route('submissions.show', ['submission' => $submission]))
            ->with('message', 'Successfully updated submission');
    }


    // delete submission
    public function destroy(Submissions $submission)
    {
        $this->authorize('delete', $submission);

        Submissions::destroy($submission->id);
        return redirect(route('submissions.index'))
            ->with('message', 'Successfully deleted submission!');
    }
}
