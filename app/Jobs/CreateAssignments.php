<?php

namespace App\Jobs;

use App\Assignments;
use App\Events;
use App\Forms;
use App\Groups;
use App\Helpers\GraphAPIHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class CreateAssignments implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $form;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Forms $form)
    {
        $this->form = $form;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // first delete old assignments then create assignments to assign staff or sites to the form deadlines
        $this->form->deleteAssignments();

        // get all the events (deadlines) for this form
        $events = Events::where('forms_id', $this->form->id)->get();

        switch ($this->form->required_for) {
            // if form is required for all staff, create assignment for each staff for each event
            case('All Staff'):
                $staff = GraphAPIHelper::getAllStaff();
                foreach ($events as $event) {
                    foreach ($staff as $staffMember) {
                        Assignments::create([
                            'events_id' => $event->id,
                            'email' => $staffMember->getMail(),
                        ]);
                    }
                }
                break;

            // if form is required for specific staff, create assignment for each staff for each event
            case('Staff'):
                $staff = new Collection();

                // loop through each group and get the staff members. Add to staff master collection
                if ($this->form->requirees_groups) {
                    foreach (explode(',', $this->form->requirees_groups) as $group) {
                        $group_members = collect(GraphAPIHelper::getGroupStaff(Groups::find($group)));
                        $group_members->each(function ($item) use ($staff) {
                            $staff->push($item->getMail());
                        });
                    }
                }
                // loop through each additional email and push to staff master collection
                if ($this->form->requirees_emails) {
                    foreach (explode(',', $this->form->requirees_emails) as $email) {
                        $staff->push($email);
                    }
                }

                // loop through each event and assign it to each staff member
                foreach ($events as $event) {
                    foreach ($staff as $staffMember) {
                        Assignments::create([
                            'events_id' => $event->id,
                            'email' => $staffMember,
                        ]);
                    }
                }
                break;

            // if form is required for specific sites, create assignment for each site for each event
            case('Sites'):
                $sites = explode(',', $this->form->requirees_sites);
                foreach ($events as $event) {
                    foreach ($sites as $site) {
                        Assignments::create([
                            'events_id' => $event->id,
                            'sites_id' => $site,
                        ]);
                    }
                }
                break;
        }
    }
}
