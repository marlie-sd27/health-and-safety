<?php

namespace App\Http\Controllers;

use App\Forms;
use Illuminate\Http\Request;

class FormsController extends Controller
{
    public function hschecklist()
    {

        $viewData = $this->loadViewData();

        return view('Forms/HSchecklist', $viewData);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $viewData = $this->loadViewData();

        $viewData['forms'] = Forms::all();

        return view('Forms/index', $viewData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $viewData = $this->loadViewData();

        return view('Forms/create', $viewData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request);

        $validated = $request->validate([
            'form_title' => 'required|max:255',
            'full_year' => 'required|boolean'
        ]);

        $form = Forms::create([
            'title' => $validated['form_title'],
            'description' => $request['form_description'],
            'recurrence' => join(",", array([$request['rec_quantity'], $request['rec_repeat'], $request['req_time_unit']])),
            'required_role' => $request['required_role'],
            'full_year' => $validated['full_year']
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Forms  $forms
     * @return \Illuminate\Http\Response
     */
    public function show(Forms $forms)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Forms  $forms
     * @return \Illuminate\Http\Response
     */
    public function edit(Forms $forms)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Forms  $forms
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Forms $forms)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Forms  $forms
     * @return \Illuminate\Http\Response
     */
    public function destroy(Forms $forms)
    {
        //
    }
}
