<?php

namespace App\Http\Controllers;

use App\Events;
use App\Submissions;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class DeadlinesController extends Controller
{

    public function ajax()
    {
            // query for the events
            $deadlines = Events::with('forms')

                // if user doesn't have reporting privileges, filter query to only return deadlines assigned to them
                ->when(!Auth::user()->hasReportingPrivileges(), function ($query) {
                    return $query->join('assignments', 'assignments.events_id', '=', 'events.id')
                        ->where('assignments.email', Auth::user()->email);
                })
                ->select('events.*')
                ->get();

            // add attribute url for links and title for displaying in calendar
            foreach ($deadlines as $deadline) {
                $deadline['url'] = route('forms.show', ['form' => $deadline->forms_id, 'event' => $deadline]);
                $deadline['title'] = $deadline->forms->title;

                // check to see if user has submitted for the assigned deadline
                if (!Auth::user()->hasReportingPrivileges())
                {
                    $submission = Events::join('submissions','events.id','=','submissions.events_id')
                        ->join('assignments','events.id','=','assignments.events_id')
                        ->whereNotNull('assignments.email')
                        ->whereColumn('submissions.email','=', 'assignments.email')
                        ->where('submissions.email','=',Auth::user()->email)
                        ->where('events.id', $deadline->id)
                        ->first();

                    // if a submissions is found, mark the deadline green
                    if ($submission)
                    {
                        $deadline['color'] = '#24b924';
                    }

                    // if a submission is not found and the deadline is overdue, mark the deadline orange
                    elseif ($deadline->date < Carbon::now())
                    {
                        $deadline['color'] = '#ff9400';
                    }
                }
            }

            return response()->json($deadlines);
    }


    // index all events
    public function index()
    {
        $events = Events::with('Forms')
            ->orderBy('date')
            ->paginate(20);

        return view('Events/index', ['events' => $events]);
    }


    // destroy specified event
    public function destroy(Events $event)
    {
        Events::destroy($event->id);
        return redirect(route('events'))->with('message', 'Successfully deleted event!');
    }


    // get all upcoming deadlines in the next 4 months
    public function upcoming()
    {
        $upcomings = Events::with('forms')
            ->where('date', '>', Carbon::now())
            ->where('date', '<', Carbon::now()->addMonths(6))
            ->orderBy('date', 'asc')
            ->get();

        return view('Events/upcoming', ['upcomings' => $upcomings]);
    }
}
