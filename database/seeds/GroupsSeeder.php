<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class GroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('groups')->insert([
            [
                'name' => 'All SD27 Staff',
                'azure_group_id' => '2fc51f9a-2f7a-4dde-b24c-4cd806b9533c',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'All Senior Administrators',
                'azure_group_id' => '77171368-886a-4cb6-abc5-87ed281c9c8d',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'All Principals and Vice Principals',
                'azure_group_id' => 'c129e0f8-4f0b-40d7-92ca-9a6160639240',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'All Teachers',
                'azure_group_id' => 'd8160f4b-b98e-463f-97be-43baedd9decc',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'All Secretaries',
                'azure_group_id' => '00d2ca51-963a-45ef-9302-28b759241416',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Custodial Department',
                'azure_group_id' => '08e91428-5f0d-4733-8c24-3546716c1cf5',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'WL Transportation',
                'azure_group_id' => '65927eb6-1e09-4aeb-a829-2865ddf689a0',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => '100 Mile Transportation',
                'azure_group_id' => '4628d56e-bcd1-4993-a2fe-38c6463b2417',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'WL Support Services Staff',
                'azure_group_id' => 'c506658f-5f2a-4357-8f17-d76eec28eebd',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => '100 Mile Support Service Staff',
                'azure_group_id' => 'f7cf171a-8b2a-4d3a-979d-c69b6707b40f',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'WL Maintenance Staff',
                'azure_group_id' => '5a47e9af-8647-462b-8b5b-640e588b647c',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => '100 Mile Maintenance Staff',
                'azure_group_id' => '4e525c6d-b0e3-458c-988c-ce4d5c508a01',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Board of Education',
                'azure_group_id' => 'cd3a5038-b426-4bb3-9020-de92b340ac30',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],

        ]);
    }
}
