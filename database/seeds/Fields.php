<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Fields extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fields')->insert([
            ['sections_id' => 1,
                'label' => 'Date',
                'name' => 'date',
                'type' => 'date',
                'required' => true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],

            ['sections_id' => 1,
                'label' => 'Name of School',
                'name' => 'school',
                'type' => 'text',
                'required' => true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],

            ['sections_id' => 1,
                'label' => 'Name of Principal',
                'name' => 'principal',
                'type' => 'text',
                'required' =>true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],

            ['sections_id' => 1,
                'label' => 'Total Enrollment',
                'name' => 'enrollment',
                'type' => 'number',
                'required' =>true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],

            ['sections_id' => 1,
                'label' => 'Date of Fire Drill',
                'name' => 'drill_date',
                'type' => 'date',
                'required' =>true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],

            ['sections_id' => 1,
                'label' => 'Precise time of Fire Drill',
                'name' => 'drill_time',
                'type' => 'time',
                'required' =>true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],

            ['sections_id' => 1,
                'label' => 'Time taken to Evacuate',
                'name' => 'evacuate_time',
                'type' => 'text',
                'required' =>true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],

            ['sections_id' => 1,
                'label' => 'Comments',
                'name' => 'comments',
                'type' => 'textarea',
                'required' =>false,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],

            ['sections_id' => 1,
                'label' => 'Signed',
                'name' => 'signature',
                'type' => 'text',
                'required' =>true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],

            ['sections_id' => 1,
                'label' => 'Title',
                'name' => 'title',
                'type' => 'text',
                'required' =>true,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
        ]);
    }
}
