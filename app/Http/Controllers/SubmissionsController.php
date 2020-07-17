<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubmission;
use App\Submissions;
use Illuminate\Http\Request;
use App\Helpers\Helper;

class SubmissionsController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }


    // show all submissions
    public function index(Request $request)
    {
        $user = $request->user ?? null;
        $form = $request->form ?? null;

        $this->viewData['submissions'] = Submissions::with('forms')->get();
        return view('Submissions.index', $this->viewData);
    }


    // store the newly created submission in the database
    public function store(StoreSubmission $validated)
    {
        Submissions::create([
            'forms_id' => $validated->form_id,
            'username' => $this->viewData['userName'],
            'email' => $this->viewData['userEmail'],
            'data' => http_build_query($validated->data),
        ]);

        return redirect(route('submissions.index'))->with('message', "Submission successful!");
    }


    // show a submission
    public function show(Submissions $submission)
    {
        $this->viewData['submission'] = $submission->prepareSubmission();
        return view('Submissions/show', $this->viewData);
    }


    // show form for editing submission
    public function edit(Submissions $submission)
    {
        $this->viewData['submission'] = $submission->prepareSubmission();
//        dd($this->viewData);
        return view('Submissions/edit', $this->viewData);
    }


    // update submission in the database
    public function update(Request $request, Submissions $submission)
    {
        //
    }


    // delete submission
    public function destroy(Submissions $submission)
    {
        Submissions::destroy($submission->id);
        return redirect(route('submissions.index'))->with('message', 'Successfully deleted submission!');
    }
}
