<?php

namespace App\Http\Controllers;

use App\Events;
use App\Forms;
use App\Http\Requests\StoreForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FormsController extends Controller
{

    // list all forms
    public function index()
    {
        return view('Forms/index', ['forms' => Forms::all()->sortBy('id')]);
    }


    // show view for creating a new form
    public function create()
    {
        return view('Forms/create');
    }


    // Store the newly created Form in database
    public function store(StoreForm $validated)
    {
        $form = Forms::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'first_occurence_at' => $validated['first_occurence_at'],
            'interval' => $validated['interval'],
            'required_for' => $validated['required_for'],
            'full_year' => $validated['full_year'],
        ]);


        // create sections and fields in database for the form
        $errors = $form->createSectionsandFields($validated);

        // if there are errors, reload the form to fix them otherwise redirect to forms.index
        return !empty($errors) ? redirect(route('forms.create'))->withErrors($errors)->withInput() : redirect(route('forms.index'));
    }


    // Show a specific form with its sections
    public function show(Forms $form, Request $request)
    {

        $event_id = $request->filled('event') ? $request->event : $form->closestDueDate();

        return (view('Forms/show', ['form' => $form->fullForm(), 'event' => Events::find($event_id) ]));
    }


    // show view for editing a form
    public function edit(Forms $form)
    {
        return view('Forms/edit', ['form' => $form->fullForm()]);
    }


    // update the form in the database with new data
    public function update(StoreForm $validated, Forms $form)
    {
        DB::transaction(function () use ($validated, $form) {

            $form->deleteAllAssociatedEvents();

            $form->update([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'first_occurence_at' => $validated['first_occurence_at'],
                'interval' => $validated['interval'],
                'required_role' => $validated['required_role'],
                'full_year' => $validated['full_year'],
            ]);

            $form->updateSectionsandFields($validated);

            $form->save();
        });


        return redirect(route('forms.show', ['form' => $form->id]))->with('message','Successfully updated the form!');
    }


    public function toggleLive(Request $request)
    {
        if (!is_bool(boolval($request->live)))
        {
            return response()->json("Value is not boolean");
        }
        $form = Forms::find($request->form);
        $form->update([
            'live' => $request->live,
        ]);
        $form->save();

        return response()->json("success");
    }


    // delete form from database
    public function destroy(Forms $form)
    {
        Forms::destroy($form->id);
        return redirect(route('forms.index'))->with('message', "Successfully deleted $form->title");
    }
}
