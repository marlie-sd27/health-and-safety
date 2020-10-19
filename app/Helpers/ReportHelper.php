<?php


namespace App\Helpers;

use App\Fields;
use App\Submissions;

class ReportHelper
{
    public static function generateReport($user, $site, $form, $date_from, $date_to)
    {
        return Submissions::join('forms', 'forms_id', '=', 'forms.id')
            ->join('users', 'submissions.email', '=', 'users.email')
            ->when($user, function ($query, $user) {
                return $query->where('users.name', 'like', '%' . $user . '%')
                    ->orWhere('users.email', 'like', '%'.$user.'%');;
            })
            ->when($site, function ($query, $site) {
                return $query->where('submissions.site', 'like', '%' . $site . '%');
            })
            ->when($form, function ($query, $form) {
                return $query->where('title', 'like', '%' . $form . '%');
            })
            ->when($date_from, function ($query, $date_from) {
                return $query->where('submissions.created_at', '>', $date_from);
            })
            ->when($date_to, function ($query, $date_to) {
                return $query->where('submissions.created_at', '<', $date_to);
            })
            ->orderBy('submissions.created_at', 'desc')
            ->select('submissions.*', 'users.name', 'forms.title')
            ->paginate(25);
    }


    public static function filterOverdues($overdues, $user, $form, $date_from, $date_to)
    {
        // convert our array of users' overdue submissions into an Eloquent collection for easy filtering
        // filter by user's search parameters
        return collect($overdues)

            // filter out users with no overdue events
            ->filter(function ($instance) {
                return sizeof($instance) > 0;
            })

            // when the user search parameter is filled, filter out collections whose key is not the user
            ->when($user, function ($collection, $user) {
                return $collection->filter(function ($value, $key) use ($user) {
                    return strstr($key, $user) != false;
                });

            })
            // when the form search parameter is filled, filter out instances who's title value is not the form
            ->when($form, function ($collection, $form) {
                return $collection->map(function ($instance) use ($form) {
                    return $instance->filter(function ($value) use ($form) {
                        return strstr($value->title, $form) != false;
                    });
                });
            })
            //
            ->when($date_from, function ($collection, $date_from) {
                return $collection->map(function ($instance) use ($date_from) {
                    return $instance->filter(function ($value) use ($date_from) {
                        return $value->date >= $date_from;
                    });
                });
            })
            ->when($date_to, function ($collection, $date_to) {
                return $collection->map(function ($instance) use ($date_to) {
                    return $instance->filter(function ($value) use ($date_to) {
                        return $value->date <= $date_to;
                    });
                });
            });
    }


    public static function prepareData($submissions)
    {

        // map through each submission and customize each row
        return $submissions->map(function ($submission) {

            // parse all the data into an array
            $submission->prepareData();

            $export = [
                'form' => $submission->title,
                'site' => $submission->site,
                'name' => $submission->name,
                'email' => $submission->email,
                'created_at' => $submission->created_at->toCookieString(),
                'updated_at' => $submission->updated_at->toCookieString(),
            ];

            foreach($submission->data as $key => $value)
            {
                $field = Fields::where('name', 'like', '%' . $key . '%')->first();
                if($field)
                {
                    $export[$field->label] = $value;
                }
            }

            return $export;
        });
    }
}
