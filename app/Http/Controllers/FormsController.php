<?php

namespace App\Http\Controllers;

use App\Forms;
use App\Http\Requests\StoreForm;
use Illuminate\Http\Request;
use Illuminate\Session\Store;

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
    public function store(StoreForm $request)
    {
        $validated = $request->validated();

        // create the form
        $form = Forms::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'recurrence' => $validated['recurrence'],
            'required_role' => $validated['required_role'],
            'full_year' => $validated['full_year'],
        ]);


        // create sections and fields in database for the form
        $errors = $form->createSectionsandFields($request);

        // if there are errors, reload the form to fix them otherwise redirect to forms.index
        return !empty($errors) ? redirect(route('forms.create', $this->viewData))->withErrors($errors)->withInput() : redirect(route('forms.index'));
    }


    // Show a specific form with its sections
    public function show(Forms $form)
    {
        $this->viewData['form'] = $form->fullForm();
        return (view('Forms/show', $this->viewData));
    }


    // show view for editing a form
    public function edit(Forms $form)
    {
        $this->viewData['form'] = $form->fullForm();
        return view('Forms/edit', $this->viewData);
    }


    // update the form in the database with new data
    public function update(StoreForm $request, Forms $form)
    {
        $validated = $request->validated();

        $form->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'recurrence' => $validated['recurrence'],
            'required_role' => $validated['required_role'],
            'full_year' => $validated['full_year']
        ]);

//        dd($validated);
        $form->save();

        return redirect(route('forms.show', ['form' => $form->id]));
    }


    // delete form from database
    public function destroy(Forms $form)
    {
        Forms::destroy($form->id);
        return redirect(route('forms.index'))->with('message', "Successfully deleted $form->title");
    }
}
