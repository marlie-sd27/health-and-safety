<?php


namespace App\Helpers;


use App\Assignments;
use App\Events;
use App\Groups;
use App\Sites;
use App\Submissions;
use App\Training;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class QueryHelper
{

    public static function getOverdues($user = null, $form = null, $date_from = null, $date_to = null, $site_staff = null, $group = null, $site_due = null, $paginate = 25)
    {
        // if site isn't null, retrieve all staff members at that site
        $site_member_emails = null;
        if($site_staff)
        {
            $site_member_emails = new Collection();
            $site_members = collect(GraphAPIHelper::getSiteStaff(Sites::find($site_staff)));
            $site_members->each(function ($item) use ($site_member_emails) {
                $site_member_emails->push($item->getMail());
            });
        }

        // if group isn't null, retrieve all staff members at that site
        $group_member_emails = null;
        if($group)
        {
            $group_member_emails = new Collection();
            $group_members = collect(GraphAPIHelper::getGroupStaff(Groups::find($group)));
            $group_members->each(function ($item) use ($group_member_emails) {
                $group_member_emails->push($item->getMail());
            });
        }

        // get first 5 overdue events
        return Events::join('forms', 'events.forms_id', '=', 'forms.id')
            ->join('assignments', 'assignments.events_id', '=', 'events.id')
            ->leftJoin('sites', 'assignments.sites_id', '=', 'sites.id')
            ->where('date', '<', Carbon::now())
            ->whereNotIn('assignments.id', function ($query) {
                $query->from('events')
                    ->join('submissions', 'events.id', '=', 'submissions.events_id')
                    ->join('assignments', 'events.id', '=', 'assignments.events_id')
                    ->whereColumn('submissions.email', '=', 'assignments.email')
                    ->orWhereColumn('submissions.sites_id', '=', 'assignments.sites_id')
                    ->select('assignments.id')
                    ->get();
            })
            // when the user search parameter is filled, filter out non-matching users
            ->when($user, function ($query, $user) {
                return $query->where('assignments.email', 'like', '%' . $user . '%');
            })
            // when the site_members is filled, filter out users not at the site
            ->when($site_member_emails, function ($query, $site_member_emails) {
                return $query->whereIn('assignments.email', $site_member_emails);
            })
            // when the group_members_emails is filled, filter out users not in the group
            ->when($group_member_emails, function ($query, $group_member_emails) {
                return $query->whereIn('assignments.email', $group_member_emails);
            })
            // when the form search parameter is filled, filter out assignments who's title is not the form
            ->when($form, function ($query, $form) {
                return $query->where('forms.title', $form);
            })
            //
            ->when($date_from, function ($query, $date_from) {
                return $query->where('events.date', '>=', $date_from);
            })
            ->when($date_to, function ($query, $date_to) {
                return $query->where('events.date', '<=', $date_to);
            })
            ->when($site_due, function( $query, $site_due) {
                return $query->where('assignments.sites_id', $site_due);
            })
            ->orderBy('date', 'asc')
            ->select('events.*', 'assignments.email', 'forms.title', 'sites.site','sites.code', 'assignments.sites_id')
            ->when($paginate, function ($query, $paginate) {
                return $query->paginate($paginate, ['*'], 'overdue');
            }, function($query) {
                return $query->get();
            });

    }


    // get all completed submissions
    public static function getCompleted($user = null, $form = null, $date_from = null, $date_to = null, $deadline = null, $site_staff = null, $group = null, $site_due = null, $paginate = 25)
    {
        // if $site_staff isn't null, retrieve all staff members at that site
        $site_member_emails = null;
        if($site_staff)
        {
            $site_member_emails = new Collection();
            $site_members = collect(GraphAPIHelper::getSiteStaff(Sites::find($site_staff)));
            $site_members->each(function ($item) use ($site_member_emails) {
                $site_member_emails->push($item->getMail());
            });
        }

        // if group isn't null, retrieve all staff members at that site
        $group_member_emails = null;
        if($group)
        {
            $group_member_emails = new Collection();
            $group_members = collect(GraphAPIHelper::getGroupStaff(Groups::find($group)));
            $group_members->each(function ($item) use ($group_member_emails) {
                $group_member_emails->push($item->getMail());
            });
        }

        return Events::join('submissions', 'events.id', '=', 'submissions.events_id')
            ->join('assignments', 'events.id', '=', 'assignments.events_id')
            ->join('forms', 'events.forms_id', '=', 'forms.id')
            ->leftJoin('sites', 'assignments.sites_id','=', 'sites.id')
            ->where( function ($query)  {
                $query->whereColumn('submissions.email', '=', 'assignments.email')
                    ->orWhereColumn('submissions.sites_id', '=', 'assignments.sites_id');
            })

            // when the user search parameter is filled, match the email
            ->when($user, function ($query, $user) {
                return $query->where('submissions.email', 'like', '%' . $user . '%');
            })
            // when the site_members_emails is filled, match emails
            ->when($site_member_emails, function ($query, $site_member_emails) {
                return $query->whereIn('assignments.email', $site_member_emails);
            })
            // when the group_members_emails is filled, match emails
            ->when($group_member_emails, function ($query, $group_member_emails) {
                return $query->whereIn('assignments.email', $group_member_emails);
            })
            // when the form search parameter is filled, find matches with the form title
            ->when($form, function ($query, $form) {
                return $query->where('forms.title', $form);
            })
            //
            ->when($date_from, function ($query, $date_from) {
                return $query->where('events.date', '>=', $date_from);
            })
            ->when($date_to, function ($query, $date_to) {
                return $query->where('events.date', '<=', $date_to);
            })
            // when deadline search parameter is filled, find the events with that exact deadline
            ->when($deadline, function ($query, $deadline) {
                return $query->where('events.id', $deadline);
            })
            ->when($site_due, function ($query, $site_due) {
                return $query->where('assignments.sites_id', $site_due);
            })
            ->orderBy('date', 'asc')
            ->select('events.date', 'assignments.email','forms.title', 'submissions.id', 'sites.site','sites.code')
            ->paginate($paginate, ['*'], 'completed');
    }


    public static function getSubmissions($user = null, $form = null, $date_from = null, $date_to = null, $deadline = null, $site_staff = null, $group = null, $site_due = null, $paginate = 25)
    {
        // if $site_staff isn't null, retrieve all staff members at that site
        $site_member_emails = null;
        if($site_staff)
        {
            $site_member_emails = new Collection();
            $site_members = collect(GraphAPIHelper::getSiteStaff(Sites::find($site_staff)));
            $site_members->each(function ($item) use ($site_member_emails) {
                $site_member_emails->push($item->getMail());
            });
        }

        // if group isn't null, retrieve all staff members at that site
        $group_member_emails = null;
        if($group)
        {
            $group_member_emails = new Collection();
            $group_members = collect(GraphAPIHelper::getGroupStaff(Groups::find($group)));
            $group_members->each(function ($item) use ($group_member_emails) {
                $group_member_emails->push($item->getMail());
            });
        }

        return Submissions::join('forms', 'forms_id', '=', 'forms.id')
            ->leftJoin('sites', 'submissions.sites_id', '=', 'sites.id')
            ->when($user, function ($query, $user) {
                return $query->where('submissions.email', 'like', '%' . $user . '%');
            })
            // when the user search parameter is filled, match the email
            ->when($user, function ($query, $user) {
                return $query->where('submissions.email', 'like', '%' . $user . '%');
            })
            // when the site_members_emails is filled, match emails
            ->when($site_member_emails, function ($query, $site_member_emails) {
                return $query->whereIn('submissions.email', $site_member_emails);
            })
            // when the group_members_emails is filled, match emails
            ->when($group_member_emails, function ($query, $group_member_emails) {
                return $query->whereIn('submissions.email', $group_member_emails);
            })
            // when the form search parameter is filled, find matches with the form title
            ->when($form, function ($query, $form) {
                return $query->where('forms.title', $form);
            })
            //
            ->when($date_from, function ($query, $date_from) {
                return $query->where('submissions.created_at', '>=', $date_from);
            })
            ->when($date_to, function ($query, $date_to) {
                return $query->where('submissions.created_at', '<=', $date_to);
            })
            // when deadline search parameter is filled, find the events with that exact deadline
            ->when($deadline, function ($query, $deadline) {
                return $query->where('events.id', $deadline);
            })
            ->when($site_due, function ($query, $site_due) {
                return $query->where('submissions.sites_id', $site_due);
            })
            ->orderBy('created_at', 'asc')
            ->select('submissions.*','forms.title')
            ->paginate($paginate, ['*']);
    }


    public static function getTrainings($email = null, $site = null, $course = null, $course_date = null, $expiry_date_from = null, $expiry_date_to = null, $paginate = null)
    {
        return Training::when($email, function ($query, $email) {
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
            ->paginate($paginate, ['*']);
    }


    public static function getAssignments($user = null, $form = null, $date_from = null, $date_to = null, $site_staff = null, $group = null, $site_due = null, $paginate = 25)
    {
        // if site isn't null, retrieve all staff members at that site
        $site_member_emails = null;
        if($site_staff)
        {
            $site_member_emails = new Collection();
            $site_members = collect(GraphAPIHelper::getSiteStaff(Sites::find($site_staff)));
            $site_members->each(function ($item) use ($site_member_emails) {
                $site_member_emails->push($item->getMail());
            });
        }

        // if group isn't null, retrieve all staff members at that site
        $group_member_emails = null;
        if($group)
        {
            $group_member_emails = new Collection();
            $group_members = collect(GraphAPIHelper::getGroupStaff(Groups::find($group)));
            $group_members->each(function ($item) use ($group_member_emails) {
                $group_member_emails->push($item->getMail());
            });
        }

        // get first 5 overdue events
        return Assignments::join('events', 'assignments.events_id', '=', 'events.id')
            ->leftJoin('sites', 'assignments.sites_id', 'sites.id')
            ->join('forms', 'events.forms_id', 'forms.id')
            ->whereNull('events.deleted_at')
            // when the user search parameter is filled, filter out non-matching users
            ->when($user, function ($query, $user) {
                return $query->where('assignments.email', 'like', '%' . $user . '%');
            })
            // when the site_members is filled, filter out users not at the site
            ->when($site_member_emails, function ($query, $site_member_emails) {
                return $query->whereIn('assignments.email', $site_member_emails);
            })
            // when the group_members_emails is filled, filter out users not in the group
            ->when($group_member_emails, function ($query, $group_member_emails) {
                return $query->whereIn('assignments.email', $group_member_emails);
            })
            // when the form search parameter is filled, filter out assignments who's title is not the form
            ->when($form, function ($query, $form) {
                return $query->where('forms.title', $form);
            })
            //
            ->when($date_from, function ($query, $date_from) {
                return $query->where('events.date', '>=', $date_from);
            })
            ->when($date_to, function ($query, $date_to) {
                return $query->where('events.date', '<=', $date_to);
            })
            ->when($site_due, function( $query, $site_due) {
                return $query->where('assignments.sites_id', $site_due);
            })
            ->orderBy('events.date', 'asc')
            ->select('events.date', 'assignments.*', 'forms.title', 'sites.site')
            ->paginate($paginate, ['*']);
    }

}
