<?php

namespace App\Http\Controllers;

use App\Courses;
use Illuminate\Http\Request;

class CoursesController extends Controller
{
    public function index()
    {
        return view('Manage/courses', ['courses' => Courses::all()->sortBy('course')]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'course' => 'string|required'
        ]);

        Courses::create($validated);
        return redirect()->route('courses');
    }


    public function update(Request $request, Courses $Courses)
    {
        return redirect()->route('courses');
    }


    public function destroy(Courses $course)
    {
        Courses::destroy($course->id);
        return redirect()->route('courses');
    }
}
