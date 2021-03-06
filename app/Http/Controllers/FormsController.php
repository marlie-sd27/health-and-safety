<?php

namespace App\Http\Controllers;

use App\Events;
use App\Forms;
use App\Groups;
use App\Http\Requests\StoreForm;
use App\Jobs\CreateAssignments;
use App\Sites;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        return view('Forms/create', [
            'sites' => Sites::all(),
            'groups' => Groups::all()
        ]);
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
            'requirees_emails' => $validated['requirees_emails'],
            'requirees_groups' => join(',', $validated['requirees_groups']),
            'requirees_sites' => join(',', $validated['requirees_sites']),
            'full_year' => $validated['full_year'],
        ]);

        // create sections and fields in database for the form
        $errors = $form->createSectionsandFields($validated);

        // create assignments to assign staff or sites to the form deadlines
        CreateAssignments::dispatch($form);

        // if there are errors, reload the form to fix them otherwise redirect to forms.index
        return !empty($errors) ? redirect(route('forms.create'))->withErrors($errors)->withInput() : redirect(route('forms.index'));
    }


    // Show a specific form with its sections
    public function show(Forms $form, Request $request)
    {

        $event_id = $request->filled('event') ? $request->event : $form->closestDueDate();

        return (view('Forms/show', [
            'form' => $form->fullForm(),
            'event' => Events::find($event_id),
            'sites' => Sites::all()->sortBy('site'),
        ]));
    }


    // show view for editing a form
    public function edit(Forms $form)
    {
        return view('Forms/edit', [
            'form' => $form->fullForm(),
            'sites' => Sites::all(),
            'groups' => Groups::all(),
        ]);
    }


    // update the form in the database with new data
    public function update(StoreForm $validated, Forms $form)
    {
        DB::transaction(function () use ($validated, $form) {

            $form->title = $validated['title'];
            $form->description = $validated['description'];
            $form->first_occurence_at = $validated['first_occurence_at'];
            $form->interval = $validated['interval'];
            $form->required_for = $validated['required_for'];
            $form->requirees_emails = $validated['requirees_emails'];
            $form->requirees_groups = join(',', $validated['requirees_groups']);
            $form->requirees_sites = join(',', $validated['requirees_sites']);
            $form->full_year = $validated['full_year'];

            // delete old events if interval or first_occurence_at attributes have been changed
            // events will be re-created when form is saved
            if ($form->isDirty(['interval', 'first_occurence_at'])) {
                $form->deleteEvents();
            };
            $form->save();


            $form->updateSectionsandFields($validated);

        }, 3);

        CreateAssignments::dispatch($form);

        return redirect(route('forms.show', ['form' => $form->id]))->with('message', 'Successfully updated the form!');
    }


    // function to receive ajax request to toggle whether or not form should be live
    public function toggleLive(Request $request)
    {
        if (!is_bool(boolval($request->live))) {
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
