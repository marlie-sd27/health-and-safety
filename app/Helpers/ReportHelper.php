<?php


namespace App\Helpers;

use App\Events;
use App\Fields;
use App\Submissions;
use Illuminate\Support\Carbon;

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
