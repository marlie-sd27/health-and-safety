<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Forms extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('forms')->insert([
            [
                'title' => 'Fire Drill Report',

                'description' => "***Records needs to be maintained on file at this location for Fire Dept. and WorkSafe BC review." .
                    "\n\nRefer to British Columbia Fire Code 2006 section 2.8.3.2 Fire Drill Frequency Section b) in schools attended by children, " .
                    "total evacuation fire drills shall be held at least 3 times in each of the fall and spring school terms." .
                    "\n\nSchools/facilities are required to forward a copy of this report to: sd27maintenance@sd27.bc.ca",

                'interval' => '1 year',
                'first_occurence_at' => '2020-10-15,2020-11-15,2021-01-15,2021-02-15,2021-04-15,2021-06-01',
                'required_for' => 'Principals and Vice Principals',
                'full_year' => false,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Health and Safety Start of Year Checklist',

                'description' => "September is a very busy time for school districts. Maintenance is trying to wrap up any summer work and ".
                    "schools are trying to settle into a new school year. As a result it is easy to lose track of things that require completion. ".
                    "This checklist has been designed to ensure that all of our worksites are prepared, in terms of health and safety, for another school year. " .
                    "\nWithin the first week of school First Aid Attendants and Joint Health and Safety Committee representatives need to be selected and designated. ".
                    "This should preferably happen during the first staff meeting at the same time as all of the information below is discussed with staff. " .
                    "\nPlease complete this checklist by September 30th.",

                'interval' => '1 year',
                'first_occurence_at' => '2020-09-30',
                'required_for' => 'Principals and Vice Principals',
                'full_year' => false,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]
        ]);
    }
}
