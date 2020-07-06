<?php

namespace App\Http\Controllers;

use App\Forms;
use Illuminate\Http\Request;

class FormsController extends Controller
{
    // to be deleted
    public function hschecklist()
    {

        $viewData = $this->loadViewData();

        return view('Forms/HSchecklist', $viewData);
    }


    // list all forms
    public function index()
    {
        $viewData = $this->loadViewData();

        $viewData['forms'] = Forms::all();

        return view('Forms/index', $viewData);
    }


    // show view for creating a new form
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

//        dd($request);

        // Recurrence schedule is blank if null
        // otherwise, join the recurrence quantity, repeat and time unit into a string separated by commas
        $recurrence = "";

        if ($request['rec_quantity'] !== null)
        {
            $recurrence = $request['rec_quantity'] . "," . $request['rec_repeat'] . "," . $request['rec_time_unit'];
        }


        // create the form
        $form = Forms::create([
            'title' => $request['form_title'],
            'description' => $request['form_description'],
            'recurrence' => $recurrence,
            'required_role' => $request['required_role'],
            'full_year' => isset($request['full_year'])
        ]);


        // create sections and fields in database for the form
        $errors = $form->createSectionsandFields($request);

        // if there are errors, reload the form to fix them
        if (!empty($errors))
        {
            $viewData = $this->loadViewData();
            return redirect(route('forms.create', $viewData))->withErrors($errors)->withInput();
        }

        // otherwise redirect to the forms index
        return redirect(route('forms.index'));
    }


    // Show a specific form with its sections
    public function show(Forms $form)
    {
        $viewData = $this->loadViewData();

        $viewData['form'] = $form->fullForm();

        // get each section's associated fields

        return (view('Forms/show', $viewData));
    }


    // show view for editing a form
    public function edit(Forms $form)
    {
        //
    }


    // update the form in the database with new data
    public function update(Request $request, Forms $form)
    {
        //
    }


    // delete form from database
    public function destroy(Forms $form)
    {
        Forms::destroy($form->id);

        return redirect(route('forms.index'))->with('message', "Sucessfully deleted $form->title");
    }
}
