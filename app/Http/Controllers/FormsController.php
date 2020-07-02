<?php

namespace App\Http\Controllers;

use App\Forms;
use App\Sections;
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

//        $validated = $request->validate([
//            'form_title' => 'required|max:255',
//            'full_year' => 'required|boolean'
//        ]);

//        dd($request);

        // Recurrence schedule is blank if null
        // otherwise, join the recurrence quantity, repeat and time unit into a string separated by commas
        $recurrence = "";

        if ($request['rec_quantity'] !== null) {
            $recurrence = $request['rec_quantity'] . "," . $request['rec_repeat'] . "," . $request['rec_time_unit'];
        }

        // if the full_year box is not set (ie unchecked), set the value to false. Otherwise set the value to true
        if (!isset($request['full_year'])) {
            $request['full_year'] = false;
        } else $request['full_year'] = true;


        // create the form and get the ID
        $form = Forms::create([
            'title' => $request['form_title'],
            'description' => $request['form_description'],
            'recurrence' => $recurrence,
            'required_role' => $request['required_role'],
            'full_year' => $request['full_year']
        ]);

        // create each section in the form
        foreach ($request->section_title as $key => $value) {
            $section = Sections::create([
                'form_id' => $form->id,
                'title' => $value,
                'description' => $request->section_description[$key],
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Forms $forms
     * @return \Illuminate\Http\Response
     */
    public function show(Forms $form)
    {
        $viewData = $this->loadViewData();

        $viewData['form'] = $form;

        return(view('Forms/show', $viewData));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Forms $forms
     * @return \Illuminate\Http\Response
     */
    public function edit(Forms $forms)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Forms $forms
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Forms $forms)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Forms $forms
     * @return \Illuminate\Http\Response
     */
    public function destroy(Forms $forms)
    {
        //
    }
}
