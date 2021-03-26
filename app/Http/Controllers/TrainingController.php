<?php

namespace App\Http\Controllers;

use App\Courses;
use Illuminate\Support\Facades\Response;
use App\Helpers\QueryHelper;
use App\Sites;
use App\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TrainingController extends Controller
{

    public function index()
    {
        return view('Training/index', [
            'trainings' => Training::where('email', Auth::user()->email)
                ->orderBy('expiry_date', 'asc')
                ->get()
        ]);
    }


    public function create()
    {
        $this->authorize('create', Training::class);
        return view('Training/create', [
            'sites' => Sites::all()->sortBy('site'),
            'courses' => Courses::all()->sortBy('course'),
        ]);
    }


    public function store(Request $request)
    {
        $this->authorize('create', Training::class);
        $request['designated_fa_attendant'] = isset($request->designated_fa_attendant);
        $validated = $request->validate([
            'course' => 'nullable|string',
            'description' => 'nullable|string',
            'email' => 'required|email',
            'course_date' => 'required|date',
            'expiry_date' => 'nullable|date',
            'inspection_date' => 'nullable|date',
            'site' => 'required|string',
            'notes' => 'nullable|string',
            'union' => 'nullable|string',
            'fa_level' => 'nullable|string',
            'full_part_hours' => 'nullable|string',
            'designated_fa_attendant' => 'nullable'
        ]);

        Training::create($validated);

        return redirect(route('training.report'))->with('message', 'Created Training Entry');
    }


    public function show(Training $training)
    {
        $this->authorize('view', $training);
        return view('Training/show', ['training' => $training]);
    }

    public function edit(Training $training)
    {
        $this->authorize('update', Training::class);
        return view('Training/edit', [
            'training' => $training,
            'sites' => Sites::all()->sortBy('site'),
            'courses' => Courses::all()->sortBy('course')
        ]);
    }


    public function update(Request $request, Training $training)
    {
        $this->authorize('update', Training::class);
        $request['designated_fa_attendant'] = isset($request->designated_fa_attendant);
        $validated = $request->validate([
            'course' => 'nullable|string',
            'description' => 'nullable|string',
            'email' => 'required|email',
            'course_date' => 'required|date',
            'expiry_date' => 'nullable|date',
            'inspection_date' => 'nullable|date',
            'site' => 'required|string',
            'notes' => 'nullable|string',
            'union' => 'nullable|string',
            'fa_level' => 'nullable|string',
            'full_part_hours' => 'nullable|string',
            'designated_fa_attendant' => 'nullable'
        ]);

        $training->update($validated);

        return redirect(route('training.show', ['training' => $training]))->with('message', 'Updated Training Entry');
    }


    public function destroy(Training $training)
    {
        $this->authorize('delete', Training::class);
        Training::destroy($training->id);
        return redirect(route('training.report'))
            ->with('message', 'Successfully deleted training!');
    }


    public function report(Request $request)
    {
        $this->authorize('report', Training::class);
        $email = $request->filled('email') ? $request->email : null;
        $site = $request->filled('site') ? $request->site : null;
        $course = $request->filled('course') ? $request->course : null;
        $course_date = $request->filled('course_date') ? $request->course_date : null;
        $expiry_date_from = $request->filled('expiry_date_from') ? $request->expiry_date_from : null;
        $expiry_date_to = $request->filled('expiry_date_to') ? $request->expiry_date_to : null;

        $trainings = QueryHelper::getTrainings($email, $site, $course, $course_date, $expiry_date_from, $expiry_date_to, 25);

        return view('Training/report', [
            'trainings' => $trainings,
            'email' => $email,
            'site' => $site,
            'course' => $course,
            'course_date' => $course_date,
            'expiry_date_from' => $expiry_date_from,
            'expiry_date_to' => $expiry_date_to,
            'sites' => Sites::all()->sortBy('site'),
            'courses' => Courses::all()->sortBy('course'),
        ]);
    }

    public function ajax()
    {
        // query for the events
        $trainings = Training::all();

        // add attribute url for links and title for displaying in calendar
        foreach ($trainings as $training) {
            $training['url'] = route('training.show', ['training' => $training->id]);
            $training['title'] = Str::title(str_replace(['@sd27.bc.ca','.'], ' ', $training->email)) . ': ' . $training->course;
            $training['date'] = $training->expiry_date;
        }

        return response()->json($trainings);
    }


    // export report as csv
    public function export(Request $request)
    {
        // get optional search filtering parameters
        $email = $request->filled('email') ? $request->email : null;
        $site = $request->filled('site') ? $request->site : null;
        $course = $request->filled('course') ? $request->course : null;
        $course_date = $request->filled('course_date') ? $request->course_date : null;
        $expiry_date_from = $request->filled('expiry_date_from') ? $request->expiry_date_from : null;
        $expiry_date_to = $request->filled('expiry_date_to') ? $request->expiry_date_to : null;

        // prepare export
        $filename = "training-export_" . Carbon::now() . ".csv";
        $headers = [
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$filename",
            'Expires' => '0',
            'Pragma' => 'public'
        ];

        // get report data and convert to array
        $trainings = QueryHelper::getTrainings($email, $site, $course, $course_date, $expiry_date_from, $expiry_date_to, null);

        // map through each submission and customize each row
        $list = $trainings->map(function ($training) {

            $export = [
                'Email' => $training->email,
                'Course' => $training->course,
                'Site' => $training->site,
                'Expires In' => $training->expiry_date ? Carbon::now()->diffInDays($training->expiry_date, false) . " days" : "N/A",
                'Course Date' => $training->course_date,
                'Expiry Date' => $training->expiry_date ,
                'Inspection Date' => $training->inspection_date,
                'Designated First Aid Attendant' => $training->designated_fa_attendant ? "True" : "False",
                'Union' => $training->union,
                'Level of First Aid Required by WorkSafe at this Site' => $training->fa_level,
                'Full/Part Time/Hours' => $training->full_part_hours,
                'Training Entry Date' => $training->created_at,
                'Notes' => $training->notes,
            ];

            return $export;
        })->toArray();

        // if there is no data, return message that there is nothing to export
        if (!$list) {
            return redirect()->back()->with('error', 'Nothing to export');
        }

        // add headers for each column in the CSV download
        array_unshift($list, array_keys($list[0]));

        // write data to csv
        $callback = function () use ($list) {
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
