<?php

namespace App\Http\Controllers;

use App\Events;
use Illuminate\Http\Request;

class EventsController extends Controller
{

    public function index(Request $request)
    {
        $start = $request->query('start');
        $end = $request->query('end');

        $events = Events::where([
            ['date', '>', $start],
            ['date', '<', $end]
        ])
            ->join('forms', 'forms_id', '=', 'forms.id')
            ->get();

        foreach ($events as $event )
        {
            $event['url'] = route('forms.show', ['form' => $event->forms_id]);
        }

        return response()->json($events);
    }



    public function destroy(Events $events)
    {

    }
}
