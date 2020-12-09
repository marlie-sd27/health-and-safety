<?php

namespace App\Http\Controllers;

use App\Courses;
use App\Sites;
use App\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainingController extends Controller
{

    public function index()
    {
        return view('Training/index', ['trainings' => Training::where('email', Auth::user()->email)->orderBy('expiry_date', 'asc')->get()]);
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
        $email = $request->filled('email') ? $request->user : null;
        $site = $request->filled('site') ? $request->site : null;
        $course = $request->filled('course') ? $request->course : null;
        $course_date = $request->filled('course_date') ? $request->course_date : null;
        $expiry_date_from = $request->filled('expiry_date_from') ? $request->expiry_date_from : null;
        $expiry_date_to = $request->filled('expiry_date_to') ? $request->expiry_date_to : null;

        $trainings = Training::when($email, function ($query, $email) {
                return $query->where('email', 'like', '%' . $email . '%');
            })
            ->when($site, function ($query, $site) {
                return $query->where('site', 'like', '%' . $site . '%');
            })
            ->when($course, function ($query, $course) {
                return $query->where('course', 'like', '%' . $course . '%');
            })
            ->when($course_date, function ($query, $course_date) {
                return $query->where('course_date', $course_date);
            })
            ->when($expiry_date_from, function ($query, $expiry_date_from) {
                return $query->where('expiry_date', '>=', $expiry_date_from);
            })
            ->when($expiry_date_to, function ($query, $expiry_date_to) {
                return $query->where('expiry_date', '<=', $expiry_date_to);
            })
            ->orderBy('expiry_date', 'asc')
            ->paginate(25);

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
}
