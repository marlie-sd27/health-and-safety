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
        $this->call([
            UserSeeder::class,
            FormsSeeder::class,
            SectionsSeeder::class,
            FieldsSeeder::class,
            SubmissionsSeeder::class,
            SecondarySchoolInspectionSeeder::class,
            RespectfulWorkplaceSeeder::class,
            ElementarySchoolInspectionAdditionsSeeder::class,
            SitesSeeder::class,
        ]);
    }
}
