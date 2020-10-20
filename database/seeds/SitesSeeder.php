<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SitesSeeder extends Seeder
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
                'site' => '100 Mile Elementary',
                'azure_group_id' => 'd46ae1c8-1c4f-4bd1-9fe6-e1f745a73826',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'site' => '100 Mile Maintenance',
                'azure_group_id' => '4e525c6d-b0e3-458c-988c-ce4d5c508a01',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'site' => '150 Mile Elementary',
                'azure_group_id' => 'c6479caf-4435-4ad3-b27a-2093997daf0b',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'site' => 'Alexis Creek',
                'azure_group_id' => '0e9b61df-9ea9-40d0-a36d-1709d4133749',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'site' => 'Anahim',
                'azure_group_id' => 'afb52d46-1046-40ae-9d88-813efb328160',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'site' => 'Big Lake',
                'azure_group_id' => '42543660-9f07-4310-b2db-267e05cdfae0',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'site' => 'Board Office',
                'azure_group_id' => 'ea456fd6-ca17-4697-8e85-318fdcec38cb',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'site' => 'Cataline',
                'azure_group_id' => 'e583214b-8067-49a7-a949-efaa4f01d8f2',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'site' => 'Chilcotin Road',
                'azure_group_id' => '878b39f1-5a3d-4eba-85c6-79b89ba1003e',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'site' => 'Dog Creek',
                'azure_group_id' => '4248ce09-31d4-442b-9920-205c8d713b47',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'site' => 'Forest Grove',
                'azure_group_id' => '7164e11f-4ff8-4c02-8e65-ea5fa9dafbaa',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'site' => 'Horse Lake',
                'azure_group_id' => '7897f484-c3d7-4c09-a0fb-f6901d9a0a6f',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'site' => 'Horsefly',
                'azure_group_id' => 'c228e574-4ae7-4b27-a7f6-dbcc89ded63e',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'site' => 'GROW WL',
                'azure_group_id' => '6471ded3-f938-46ce-8a0a-25e6d8fc3c7a',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'site' => 'Lac La Hache',
                'azure_group_id' => '70a907c4-cb16-407e-a357-a96665c0ba51',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'site' => 'LCS-Williams Lake',
                'azure_group_id' => '6d33ad4d-eb55-49ba-ac6b-e0fd8879db77',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'site' => 'LCS-Columneetza',
                'azure_group_id' => '96b1fd34-7fb8-4861-b109-829db7d35c2a',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'site' => 'Likely',
                'azure_group_id' => 'd77803ea-e869-4a40-b195-c58d96a86652',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'site' => 'Marie Sharpe',
                'azure_group_id' => '43398862-392f-4d81-b4c2-79e691048f98',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'site' => 'Mile 108 Elementary',
                'azure_group_id' => 'eb31fa3c-05fb-4422-9127-db01097f1b8b',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'site' => 'Mountview',
                'azure_group_id' => '9b97b4b6-d765-4e20-bac7-36eab49eebbb',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'site' => 'Naghtaneqed',
                'azure_group_id' => 'c4f471fd-e060-4469-9d08-815a658d4117',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'site' => 'Nenqayni',
                'azure_group_id' => '69a060df-18a7-4d32-bec0-0f54dc28f591',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'site' => 'Nesika',
                'azure_group_id' => '7129f052-d91d-4db7-8a73-d44b8b4bf7aa',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'site' => 'PSO',
                'azure_group_id' => '6ad9db53-e968-423d-b007-f75dd45b95a4',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'site' => 'Support Services',
                'azure_group_id' => 'c506658f-5f2a-4357-8f17-d76eec28eebd',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'site' => 'Tatla Lake',
                'azure_group_id' => 'b78b1ed0-9702-4356-a9ec-8f29fc24360a',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'site' => 'Williams Lake Maintenance',
                'azure_group_id' => '5a47e9af-8647-462b-8b5b-640e588b647c',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'site' => 'Williams Lake Transportation',
                'azure_group_id' => 'd9547221-0c9f-40a5-ac0b-8fc71d1ab43e',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
        ]);
    }
}
