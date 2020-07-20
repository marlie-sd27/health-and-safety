<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(Admins::class);
        $this->call(Forms::class);
        $this->call(Sections::class);
        $this->call(Fields::class);
    }
}
