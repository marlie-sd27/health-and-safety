<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class GroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sites')->insert([
            [
                'name' => 'All Principals and Vice Principals',
                'azure_group_id' => 'c129e0f8-4f0b-40d7-92ca-9a6160639240',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
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
                'name' => 'All Teachers',
                'azure_group_id' => 'd8160f4b-b98e-463f-97be-43baedd9decc',
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
                'name' => '100 Mile Elementary',
                'azure_group_id' => '2fc51f9a-2f7a-4dde-b24c-4cd806b9533c',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => '100 Mile Elementary',
                'azure_group_id' => '2fc51f9a-2f7a-4dde-b24c-4cd806b9533c',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => '100 Mile Elementary',
                'azure_group_id' => '2fc51f9a-2f7a-4dde-b24c-4cd806b9533c',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
        ]);
    }
}
