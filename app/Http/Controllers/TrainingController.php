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
        $request['designated_fa_attendant'] = isset($this->designated_fa_attendant);
        $validated = $request->validate([
            'course' => 'required|string',
            'description' => 'nullable|string',
            'email' => 'required|email',
            'course_date' => 'required|date',
            'expiry_date' => 'nullable|date',
            'site' => 'nullable|string',
            'notes' => 'nullable|string',
            'designated_fa_attendant' => 'nullable|boolean',
            'union' => 'nullable|string',
            'fa_level' => 'nullable|string',
            'full_part_hours' => 'nullable|string',
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
        return view('Training/edit', ['training' => $training]);
    }


    public function update(Request $request, Training $training)
    {
        $this->authorize('update', Training::class);
        $request['designated_fa_attendant'] = isset($this->designated_fa_attendant);
        $validated = $request->validate([
            'course' => 'required|string',
            'description' => 'nullable|string',
            'email' => 'required|email',
            'course_date' => 'required|date',
            'expiry_date' => 'nullable|date',
            'site' => 'nullable|string',
            'notes' => 'nullable|string',
            'designated_fa_attendant' => 'nullable|boolean',
            'union' => 'nullable|string',
            'fa_level' => 'nullable|string',
            'full_part_hours' => 'nullable|string',
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
        $user = $request->filled('user') ? $request->user : null;
        $site = $request->filled('site') ? $request->site : null;
        $course = $request->filled('course') ? $request->course : null;
        $course_date = $request->filled('course_date') ? $request->course_date : null;
        $expiry_date = $request->filled('expiry_date') ? $request->expiry_date : null;

        $trainings = Training::when($user, function ($query, $user) {
                return $query->where('email', 'like', '%' . $user . '%');
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
            ->when($expiry_date, function ($query, $expiry_date) {
                return $query->where('expiry_date', $expiry_date);
            })
            ->orderBy('expiry_date', 'asc')
            ->paginate(25);

        return view('Training/report', [
            'trainings' => $trainings,
            'user' => $user,
            'site' => $site,
            'course' => $course,
            'course_date' => $course_date,
            'expiry_date' => $expiry_date,
            'sites' => Sites::all()->sortBy('site'),
            'courses' => Courses::all()->sortBy('course'),
        ]);
    }
}
