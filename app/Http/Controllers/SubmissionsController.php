<?php

namespace App\Http\Controllers;

use App\Submissions;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;

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
    public function store(Request $request)
    {
        $data = array();
        foreach($request->data as $key => $value)
        {
            $data[$key] = $value;
        }
        Submissions::create([
            'forms_id' => $request->form_id,
            'username' => $this->viewData['userName'],
            'email' => $this->viewData['userEmail'],
            'data' => http_build_query($data),
        ]);

        return redirect(route('submissions.index'))->with('message', "Submission successful!");
    }

    // show a submission
    public function show(Submissions $submission)
    {
        $submission['data'] = explode(',,,', $submission['data']);
        $submission['form'] = $submission->forms->fullForm();
        $this->viewData['submission'] = $submission;

        dd($this->viewData);
        return view('Submissions/show', $this->viewData);
    }


    // show form for editing submission
    public function edit(Submissions $submission)
    {
        $this->viewData['form'] = $submission->forms->fullForm();
        $this->viewData['submission'] = $submission;

        return view('Submissions/edit', $this->viewData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Submissions  $submissions
     * @return \Illuminate\Http\Response
     */
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
