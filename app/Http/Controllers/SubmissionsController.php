<?php

namespace App\Http\Controllers;

use App\Submissions;
use Illuminate\Http\Request;

class SubmissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    // store the newly created submission in the database
    public function store(Request $request)
    {
        $viewData = $this->loadViewData();

        dd($request);

        Submissions::create([
            'form_id' => $request->form_id,
            'username' => $viewData->userName,
            'email' => $viewData->userEmail,
            'data' => join(',', $request->parameters)
        ]);
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
