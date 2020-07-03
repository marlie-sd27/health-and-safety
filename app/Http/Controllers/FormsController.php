<?php

namespace App\Http\Controllers;

use App\Forms;
use App\Sections;
use App\Fields;
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


    // Store the newly created Form in database
    public function store(Request $request)
    {

//        $validated = $request->validate([
//            'form_title' => 'required|max:255',
//            'full_year' => 'required|boolean'
//        ]);

        dd($request);

        // Recurrence schedule is blank if null
        // otherwise, join the recurrence quantity, repeat and time unit into a string separated by commas
        $recurrence = "";

        if ($request['rec_quantity'] !== null)
        {
            $recurrence = $request['rec_quantity'] . "," . $request['rec_repeat'] . "," . $request['rec_time_unit'];
        }


        // create the form and get the ID
        $form = Forms::create([
            'title' => $request['form_title'],
            'description' => $request['form_description'],
            'recurrence' => $recurrence,
            'required_role' => $request['required_role'],
            'full_year' => isset($request['full_year'])
        ]);


        $section_ids = array();

        // create each section in the form
        foreach ($request->section_title as $key => $value)
        {
            $section = Sections::create([
                'title' => $value,
                'forms_id' => $form->id,
                'description' => $request->section_description[$key],
            ]);

            $section_ids[$request['id'][$key]] = $section->id;
        }



        // create each field in the form
        foreach ($request->label as $key => $value)
        {
            Fields::create([
                'sections_id' => $section_ids[$request['section_id'][$key]],
                'label' => $value,
                'name' => $value,
                'type' => $request['type'][$key],
                'required' => isset($request['required'][$key]),
            ]);
        }
    }


    // Show a specific form with its sections
    public function show(Forms $form)
    {
        $viewData = $this->loadViewData();

        $viewData['form'] = $form->fullForm();

        // get each section's associated fields

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
