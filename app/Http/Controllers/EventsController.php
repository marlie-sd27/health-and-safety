<?php

namespace App\Http\Controllers;

use App\Assignments;
use App\Events;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class EventsController extends Controller
{

    public function ajax(Request $request)
    {

            // query for the events
            $events = Events::with('forms')

                // if user is not an admin, filter query to only return events they are assigned to
                ->when(!Auth::user()->isAdmin(), function ($query) {
                    return $query->join('assignments', 'assignments.events_id', '=', 'events.id')
                        ->where('assignments.email', Auth::user()->email);
                })
                ->select('events.*')
                ->get();

            // add attribute url for links and title for displaying in calendar
            foreach ($events as $event) {
                $event['url'] = route('forms.show', ['form' => $event->forms_id, 'event' => $event]);
                $event['title'] = $event->forms->title;
            }

            return response()->json($events);
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
