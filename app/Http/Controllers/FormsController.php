<?php

namespace App\Http\Controllers;

use App\Forms;
use Illuminate\Http\Request;

class FormsController extends Controller
{

    public function __construct()
    {
        $this->middleware('isadmin', ['except' => ['show']]);
        parent::__construct();
    }

    // list all forms
    public function index()
    {
        $this->viewData['forms'] = Forms::all();

        return view('Forms/index', $this->viewData);
    }


    // show view for creating a new form
    public function create()
    {
        return view('Forms/create', $this->viewData);
    }


    // Store the newly created Form in database
    public function store(Request $request)
    {
        // join the recurrence quantity, repeat and time unit into a string separated by commas
        $recurrence = null;

        if ($request->rec_quantity !== null)
        {
            $recurrence = $request->rec_quantity . "," . $request->rec_repeat . "," . $request->rec_time_unit;
        }


        // create the form
        $form = Forms::create([
            'title' => $request->form_title,
            'description' => $request->form_description,
            'recurrence' => $recurrence,
            'required_role' => $request->required_role,
            'full_year' => isset($request->full_year)
        ]);


        // create sections and fields in database for the form
        $errors = $form->createSectionsandFields($request);

        // if there are errors, reload the form to fix them
        if (!empty($errors))
        {
            return redirect(route('forms.create', $this->viewData))->withErrors($errors)->withInput();
        }

        // otherwise redirect to the forms index
        return redirect(route('forms.index'));
    }


    // Show a specific form with its sections
    public function show(Forms $form)
    {
        $viewData['form'] = $form->fullForm();
        return (view('Forms/show', $this->viewData));
    }


    // show view for editing a form
    public function edit(Forms $form)
    {
        $viewData['form'] = $form->fullForm();

        return view('Forms/edit', $this->viewData);
    }


    // update the form in the database with new data
    public function update(Request $request, Forms $form)
    {
        $recurrence = $request->rec_quantity !== null ? $recurrence = $request->rec_quantity . "," . $request->rec_repeat . "," . $request->rec_time_unit : null;

        $form->update([
            'title' => $request->form_title,
            'description' => $request->form_description,
            'recurrence' => $recurrence,
            'required_role' => $request->required_role,
            'full_year' => isset($request->full_year)
        ]);

        $form->save();

        return redirect(route('forms.show', ['form' => $form->id]));
    }


    // delete form from database
    public function destroy(Forms $form)
    {
        Forms::destroy($form->id);

        return redirect(route('forms.index'))->with('message', "Sucessfully deleted $form->title");
    }
}
