<?php


namespace App\Helpers;


use App\Events;
use App\Groups;
use App\Sites;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class QueryHelper
{

    public static function getOverdues($user = null, $form = null, $date_from = null, $date_to = null, $site = null, $group = null, $paginate = 25)
    {
        // if site isn't null, retrieve all staff members at that site
        $site_member_emails = null;
        if($site)
        {
            $site_member_emails = new Collection();
            $site_members = collect(GraphAPIHelper::getSiteStaff(Sites::firstWhere('site', $site)));
            $site_members->each(function ($item) use ($site_member_emails) {
                $site_member_emails->push($item->getMail());
            });
        }

        // if group isn't null, retrieve all staff members at that site
        $group_member_emails = null;
        if($group)
        {
            $group_member_emails = new Collection();
            $group_members = collect(GraphAPIHelper::getGroupStaff(Groups::firstWhere('name', $group)));
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
            ->orderBy('date', 'asc')
            ->select('events.*', 'assignments.email', 'forms.title', 'sites.site')
            ->paginate($paginate, ['*'], 'overdue');
    }


    // get all completed submissions
    public static function getCompleted($user = null, $form = null, $date_from = null, $date_to = null, $deadline = null, $site = null, $group = null, $paginate = 25)
    {
        // if site isn't null, retrieve all staff members at that site
        $site_member_emails = null;
        if($site)
        {
            $site_member_emails = new Collection();
            $site_members = collect(GraphAPIHelper::getSiteStaff(Sites::firstWhere('site', $site)));
            $site_members->each(function ($item) use ($site_member_emails) {
                $site_member_emails->push($item->getMail());
            });
        }

        // if group isn't null, retrieve all staff members at that site
        $group_member_emails = null;
        if($group)
        {
            $group_member_emails = new Collection();
            $group_members = collect(GraphAPIHelper::getGroupStaff(Groups::firstWhere('name', $group)));
            $group_members->each(function ($item) use ($group_member_emails) {
                $group_member_emails->push($item->getMail());
            });
        }

        return Events::join('submissions', 'events.id', '=', 'submissions.events_id')
            ->join('assignments', 'events.id', '=', 'assignments.events_id')
            ->join('forms', 'events.forms_id', '=', 'forms.id')
            ->leftJoin('sites', 'assignments.sites_id','=', 'sites.id')
            ->whereColumn('submissions.email', '=', 'assignments.email')
            ->orWhereColumn('submissions.sites_id', '=', 'assignments.sites_id')

            // when the user search parameter is filled, filter out collections whose key is not the user
            ->when($user, function ($query, $user) {
                return $query->where('submissions.email', 'like', '%' . $user . '%');
            })
            // when the site_members_emails is filled, filter out users not at the site
            ->when($site_member_emails, function ($query, $site_member_emails) {
                return $query->whereIn('assignments.email', $site_member_emails);
            })
            // when the group_members_emails is filled, filter out users not in the group
            ->when($group_member_emails, function ($query, $group_member_emails) {
                return $query->whereIn('assignments.email', $group_member_emails);
            })
            // when the form search parameter is filled, filter out instances who's title value is not the form
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
            ->when($deadline, function ($query, $deadline) {
                return $query->where('events.id', $deadline);
            })
            ->when($site, function ($query, $site) {
                return $query->where('submissions.site', $site);
            })
            ->orderBy('date', 'asc')
            ->select('events.date', 'assignments.email','forms.title', 'submissions.id', 'sites.site')
            ->paginate($paginate, ['*'], 'completed');
    }
}
