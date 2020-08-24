<?php

namespace App\Http\Controllers;

use App\Events;
use App\Helpers\Helper;
use Illuminate\Http\Request;

class EventsController extends Controller
{

    public function ajax(Request $request)
    {
        $start = $request->filled('start') ? $request->query('start') : null;
        $end = $request->filled('end') ? $request->query('end') : null;

        // query for the events between start and end date
        $events = Events::with('forms')
            ->when($start, function ($query, $start) {
                return $query->where('date', '>', $start);
            })
            ->when($end, function ($query, $end) {
                return $query->where('date', '<', $end);
            })
            ->get();


        // add attribute url for links and title for displaying in calendar
        foreach ($events as $event) {
            $event['url'] = route('forms.show', ['form' => $event->forms_id, 'event' => $event->id]);
            $event['title'] = $event->forms->title;
        }

        $events = Helper::filterEvents($events);

        return response()->json($events);
    }


    public function index()
    {
        $events = Events::with('Forms')
            ->orderBy('date')
            ->paginate(20);

        return view('events', ['events' => $events]);
    }

    public function destroy(Events $event)
    {
        Events::destroy($event->id);
        return redirect(route('events'))->with('message', 'Successfully deleted event!');
    }
}
