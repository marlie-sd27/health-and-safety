<?php

namespace App\Http\Controllers;

use App\Events;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        if (!Auth::user()->isPrincipal())
        {
            $filtered = $events->where('required_for', 'All Staff');
        }


        return response()->json($events);
    }



    public function destroy(Events $events)
    {

    }
}
