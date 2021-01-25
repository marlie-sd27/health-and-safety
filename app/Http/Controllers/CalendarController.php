<?php

namespace App\Http\Controllers;

use App\Events;
use App\Helpers\QueryHelper;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function calendar()
    {
        return view('calendar');
    }


    // depending on privileges, return different deadlines
    public function deadlines()
    {
        $user = Auth::user();

        if($user->isAdmin() || $user->isReporter()){
            return $this->allDeadlines();

        } else if($user->isPrincipal()) {
            return $this->principalDeadlines();

        } else {
            return $this->userDeadlines();

        }
    }


    // return all deadlines
    private function allDeadlines()
    {
        $deadlines = Events::with('forms')->get();
        foreach ($deadlines as $deadline) {
            $deadline['url'] = route('forms.show', ['form' => $deadline->forms_id, 'event' => $deadline]);
            $deadline['title'] = $deadline->forms->title;
        }
        return response()->json($deadlines);
    }


    private function principalDeadlines()
    {
        $deadlines = Events::with('forms')
            ->join('assignments', 'assignments.events_id', '=', 'events.id')
            ->leftJoin('sites', 'sites.id', '=', 'assignments.sites_id')
            ->where('assignments.email', Auth::user()->email)
            ->orWhere('sites.code', Auth::user()->site)
            ->select('events.*')
            ->get();

        // add attribute url for links and title for displaying in calendar
        foreach ($deadlines as $deadline) {
            $deadline['url'] = route('forms.show', ['form' => $deadline->forms_id, 'event' => $deadline]);
            $deadline['title'] = $deadline->forms->title;

            // query for a completed submission for this event for this user or their site
            $submission = QueryHelper::getCompleted(null, null, null, null, $deadline->id);
            $submission = $submission->filter(function ($s) {
                return $s->email === Auth::user()->email || $s->code === Auth::user()->site;
            });

            // if a submissions is found, mark the deadline green
            if (sizeof($submission) > 0) {
                $deadline['color'] = '#24b924';
            } // if a deadline is overdue, mark the deadline orange
            elseif ($deadline->date < Carbon::now()) {
                $deadline['color'] = '#ff9400';
            }
        }

        return response()->json($deadlines);
    }


    // return deadlines for a user
    private function userDeadlines()
    {
        $deadlines = Events::with('forms')
            ->join('assignments', 'assignments.events_id', '=', 'events.id')
            ->leftJoin('sites', 'sites.id', '=', 'assignments.sites_id')
            ->where('assignments.email', Auth::user()->email)
            ->select('events.*')
            ->get();

        // add attribute url for links and title for displaying in calendar
        foreach ($deadlines as $deadline) {
            $deadline['url'] = route('forms.show', ['form' => $deadline->forms_id, 'event' => $deadline]);
            $deadline['title'] = $deadline->forms->title;

            // query for a completed submission for this event for this user or their site
            $submission = QueryHelper::getCompleted(null, null, null, null, $deadline->id);
            $submission = $submission->filter(function ($s) {
                return $s->email === Auth::user()->email;
            });

            // if a submissions is found, mark the deadline green
            if (sizeof($submission) > 0) {
                $deadline['color'] = '#24b924';
            } // if a deadline is overdue, mark the deadline orange
            elseif ($deadline->date < Carbon::now()) {
                $deadline['color'] = '#ff9400';
            }
        }

        return response()->json($deadlines);
    }

}
