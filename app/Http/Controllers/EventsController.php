<?php

namespace App\Http\Controllers;

use App\Events;
use App\Helpers\Helper;
use Illuminate\Http\Request;

class EventsController extends Controller
{

    public function index(Request $request)
    {
        $start = $request->query('start');
        $end = $request->query('end');

        // query for the events between start and end date
        $events = Events::with('forms')
            ->where('date', '>', $start)
            ->where('date', '<', $end)
            ->get();


        // add attribute url for links and title for displaying in calendar
        foreach ($events as $event) {
            $event['url'] = route('forms.show', ['form' => $event->forms_id, 'event' => $event->id]);
            $event['title'] = $event->forms->title;
        }

        $events = Helper::filterEvents($events);

        return response()->json($events);
    }


    public function destroy(Events $events)
    {

    }
}
