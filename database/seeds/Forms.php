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
            'title' => 'Fire Drill Report',

            'description' => "***Records needs to be maintained on file at this location for Fire Dept. and WorkSafe BC review.
            \n\nRefer to British Columbia Fire Code 2006 section 2.8.3.2 Fire Drill Frequency Section b) in schools attended by children,
            total evacuation fire drills shall be held at least 3 times in each of the fall and spring school terms.
            \n\nSchools/facilities are required to forward a copy of this report to: sd27maintenance@sd27.bc.ca",

            'interval' => '45 days',
            'first_occurence_at' => '2020-09-30',
            'required_for' => 'All Staff',
            'full_year' => true,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
