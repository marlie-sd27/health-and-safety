<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Marlie Dueck',
                'email' => 'marlie.dueck@sd27.bc.ca',
                'admin' => true,
                'principal' => true,
                'elementary_principal' => true,
                'last_login' => Carbon::now()->format('Y-m-d H:i:s'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Marlie Teacher',
                'email' => 'marlie.teacher@sd27.bc.ca',
                'admin' => false,
                'principal' => true,
                'elementary_principal' => true,
                'last_login' => Carbon::now()->format('Y-m-d H:i:s'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Marlie Student',
                'email' => 'marlie.student@sd27.bc.ca',
                'admin' => false,
                'principal' => false,
                'elementary_principal' => false,
                'last_login' => Carbon::now()->format('Y-m-d H:i:s'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'John Doe',
                'email' => 'john.doe@sd27.bc.ca',
                'admin' => false,
                'principal' => false,
                'elementary_principal' => false,
                'last_login' => Carbon::now()->format('Y-m-d H:i:s'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Morgan Freeman',
                'email' => 'morgan.freeman@sd27.bc.ca',
                'admin' => false,
                'principal' => true,
                'elementary_principal' => true,
                'last_login' => Carbon::now()->format('Y-m-d H:i:s'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Angelina Jolie',
                'email' => 'angelina.jolie@sd27.bc.ca',
                'admin' => false,
                'principal' => false,
                'elementary_principal' => false,
                'last_login' => Carbon::now()->format('Y-m-d H:i:s'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Ryan Reynolds',
                'email' => 'ryan.reynolds@sd27.bc.ca',
                'admin' => false,
                'principal' => false,
                'elementary_principal' => false,
                'last_login' => Carbon::now()->format('Y-m-d H:i:s'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Oprah Winfrey',
                'email' => 'oprah.winfrey@sd27.bc.ca',
                'admin' => false,
                'principal' => true,
                'elementary_principal' => true,
                'last_login' => Carbon::now()->format('Y-m-d H:i:s'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Alex Trebek',
                'email' => 'alex.trebek@sd27.bc.ca',
                'admin' => false,
                'principal' => true,
                'elementary_principal' => false,
                'last_login' => Carbon::now()->format('Y-m-d H:i:s'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]

        ]);
    }
}
