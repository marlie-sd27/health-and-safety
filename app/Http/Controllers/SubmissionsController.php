<?php

namespace App\Http\Controllers;

use App\Submissions;
use Illuminate\Http\Request;

class SubmissionsController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }


    // show all submissions
    public function index()
    {
        $this->viewData['submissions'] = Submissions::join('forms','forms.id','=','submissions.forms_id')->get();
        return view('Submissions.index', $this->viewData);
    }


    // show form to create a submission
    public function create()
    {
        //
    }


    // store the newly created submission in the database
    public function store(Request $request)
    {
//        dd($request);

        Submissions::create([
            'forms_id' => $request->form_id,
            'username' => $this->viewData['userName'],
            'email' => $this->viewData['userEmail'],
            'data' => 'data'
        ]);

        return redirect(route('submissions.index'))->with('message', "Submission successful!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Submissions  $submissions
     * @return \Illuminate\Http\Response
     */
    public function show(Submissions $submissions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Submissions  $submissions
     * @return \Illuminate\Http\Response
     */
    public function edit(Submissions $submissions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Submissions  $submissions
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Submissions $submissions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Submissions  $submissions
     * @return \Illuminate\Http\Response
     */
    public function destroy(Submissions $submissions)
    {
        //
    }
}
