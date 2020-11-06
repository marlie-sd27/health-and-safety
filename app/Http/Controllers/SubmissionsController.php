<?php

namespace App\Http\Controllers;

use App\Forms;
use App\Helpers\Helper;
use App\Http\Requests\StoreSubmission;
use App\Sites;
use App\Submissions;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SubmissionsController extends Controller
{

    // show all submissions for logged in user
    public function index()
    {
        return view('Submissions.index', [
            'submissions' => Submissions::with('forms')
                ->where('email', '=',Auth::user()->email)
                ->orderBy('created_at', 'desc')
                ->get()
        ]);
    }


    // store the newly created submission in the database
    public function store(StoreSubmission $validated)
    {
        // if any files are uploaded, store them properly and put the path into the files array
        $files = array();
        if( isset($validated->files))
        {
            foreach ($validated->files as $key => $value)
            {
                $fileName = $key . "-" . Auth::user()->name . "-" . Carbon::now()->toDateString() . "." . $validated->file($key)->extension();
                $path = $validated->file($key)->storeAs( Forms::find($validated->form_id)->title, $fileName);
                $files[$key] = $path;
            }
        }

        Submissions::create([
            'forms_id' => $validated->form_id,
            'events_id' => $validated->event_id,
            'site' => $validated->site,
            'email' => Auth::user()->email,
            'data' => $validated->data,
            'files' => http_build_query($files),
        ]);

        return redirect(route('submissions.index'))
            ->with('message', "Submission successful!");
    }


    // show a submission
    public function show(Submissions $submission)
    {
        $this->authorize('view', $submission);
        return view('Submissions/show', ['submission' => $submission->prepareSubmission()]);
    }


    // show form for editing submission
    public function edit(Submissions $submission)
    {
        $this->authorize('update', $submission);
        return view('Submissions/edit', [
            'submission' => $submission->prepareSubmission(),
            'sites' => Sites::all()->sortBy('site'),
        ]);
    }


    // update submission in the database
    public function update(StoreSubmission $validated, Submissions $submission)
    {
        $this->authorize('update', $submission);

        // delete previous file uploads for the submission
        $oldFiles = Helper::parseHTTPQuery($submission->files);
        foreach($oldFiles as $file)
        {
            if( Storage::exists($file))
            {
                Storage::delete($file);
            }
        }

        // if any files are uploaded, store them properly and put the path into the files array
        $files = array();
        if( isset($validated->files))
        {
            foreach ($validated->files as $key => $value)
            {
                Log::debug($key);
                Log::debug($value);
                Log::debug(Auth::user()->name);
                Log::debug($validated->file($key)->extension());
                $fileName = $key . "-" . Auth::user()->name . "-" . Carbon::now()->toDateString() . "." . $validated->file($key)->extension();
                $path = $validated->file($key)->storeAs( $submission->forms->title, $fileName);
                $files[$key] = $path;
            }
        }



        $submission->update([
            'site' => $validated->site,
            'data' => $validated->data,
            'files' => http_build_query($files),
        ]);
        $submission->save();

        return redirect(route('submissions.show', ['submission' => $submission]))
            ->with('message', 'Successfully updated submission');
    }


    // delete submission
    public function destroy(Submissions $submission)
    {
        $this->authorize('delete', $submission);

        Submissions::destroy($submission->id);
        return redirect(route('submissions.report'))
            ->with('message', 'Successfully deleted submission!');
    }
}
