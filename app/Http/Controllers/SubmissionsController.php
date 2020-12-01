<?php

namespace App\Http\Controllers;

use App\Events;
use App\Forms;
use App\Helpers\Helper;
use App\Helpers\QueryHelper;
use App\Helpers\ReportHelper;
use App\Http\Requests\StoreSubmission;
use App\Sites;
use App\Submissions;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class SubmissionsController extends Controller
{

    // show all submissions for logged in user
    public function index(Request $request)
    {
        // if user can view all submissions, show all submissions with optional search parameters
        if(Auth::user()->hasReportingPrivileges())
        {
            // get optional search filtering parameters
            $this->authorize('report', Submissions::class);
            $user = $request->filled('user') ? $request->user : null;
            $site = $request->filled('site') ? $request->site : null;
            $form = $request->filled('form') ? $request->form : null;
            $date_from = $request->filled('date_from') ? $request->date_from : null;
            $date_to = $request->filled('date_to') ? $request->date_to : null;

            // generate report with filtering parameters
            $submissions = ReportHelper::generateReport($user, $site, $form, $date_from, $date_to);

            return view('Submissions/report', [
                'submissions' => $submissions,
                'user' => $user,
                'site' => $site,
                'form' => $form,
                'date_from' => $date_from,
                'date_to' => $date_to,
                'sites' => Sites::all()->sortBy('site'),
            ]);
        }

        // otherwise show only this user's submissions
        return view('Submissions/index', [
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
            'sites_id' => $validated->sites_id,
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
                $fileName = $key . "-" . Auth::user()->name . "-" . Carbon::now()->toDateString() . "." . $validated->file($key)->extension();
                $path = $validated->file($key)->storeAs( $submission->forms->title, $fileName);
                $files[$key] = $path;
            }
        }



        $submission->update([
            'sites_id' => $validated->sites_id,
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
        return redirect(route('submissions.index'))
            ->with('message', 'Successfully deleted submission!');
    }


    // export report as csv
    public function export(Request $request)
    {
        // get optional search filtering parameters
        $form = $request->filled('form') ? $request->form : null;
        $site = $request->filled('site') ? $request->site : null;
        $user = $request->filled('user') ? $request->user : null;
        $date_from = $request->filled('date_from') ? $request->date_from : null;
        $date_to = $request->filled('date_to') ? $request->date_to : null;

        // if form filter doesn't exist, return message that exports are only available with form filter
        if (!$form)
        {
            return redirect(route('report'))->with('error','Exports are only available when a form is specified in the search parameters');
        }

        // otherwise, prepare export
        $filename = $form . "_" . Carbon::now() . ".csv";
        $headers = [
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$filename",
            'Expires' => '0',
            'Pragma' => 'public'
        ];

        // get report data and convert to array
        $list = ReportHelper::generateReport( $user, $site, $form, $date_from, $date_to);
        $list = ReportHelper::prepareData($list)->toArray();

        // if there is no data, return nessage that there is nothing to export
        if(!$list){
            return redirect()->back()->with('error', 'Nothing to export');
        }

        // add headers for each column in the CSV download
        array_unshift($list, array_keys($list[0]));

        // write data to csv
        $callback = function() use ($list)
        {
            $FH = fopen('php://output', 'w');
            foreach ($list as $row) {
                fputcsv($FH, $row);
            }
            fclose($FH);
        };

        // return csv as a downloadable
        return Response::stream($callback, 200, $headers);
    }
}
