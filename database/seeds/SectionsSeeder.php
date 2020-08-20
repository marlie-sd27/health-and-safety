<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sections')->insert([
            [
                'forms_id' => 1,
                'title' => '',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 2,
                'title' => "Joint Health and Safety Committee Members",
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 2,
                'title' => "First Aid Attendants",
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 2,
                'title' => '',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 2,
                'title' => '',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 3,
                'title' => '',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 3,
                'title' => 'Building Exterior and Site',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 3,
                'title' => '1. Are all handrails in place, and in good order?',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 3,
                'title' => '2. Is siding and paint in good condition?',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 3,
                'title' => '3. Are stairways in good repair?',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 3,
                'title' => '4. Are stairways clear of any material that may cause tripping hazard?',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 3,
                'title' => '5. Are driveways and parking lots in good condition?',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 3,
                'title' => '6. Are playfields in good condition?',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 3,
                'title' => '7. Are outside walkways and parking lot in good repair?',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 3,
                'title' => '8. In winter, are sidewalks sufficiently cleared and salted/sanded?',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 3,
                'title' => '9. Are play structures in good condition?',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 3,
                'title' => '10. Are garbage facilities in good shape and locked?',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 3,
                'title' => 'Building Common Areas: lobbies, washrooms, hallways, stairways, exits etc.',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 3,
                'title' => '11. Do all exit doors work properly?',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 3,
                'title' => '12. Exit signs – are they illuminated?',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 3,
                'title' => '13. Are stairways in good repair?',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 3,
                'title' => '14. Are stairways clear of any material that may cause tripping hazard?',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 3,
                'title' => '15. Are all ceiling tiles in place and in good condition?',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 3,
                'title' => '16. Are hallways clear from clutter that may cause a tripping hazard or disrupt orderly evacuation?',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 3,
                'title' => '17. Are all cabinetry, stalls, mirrors and fixtures in good condition?',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 3,
                'title' => '18. Are mats and gratings in good repair?',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 3,
                'title' => '19. Do all electrical panels have 1M clearance in front of them?',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 3,
                'title' => '20. Are paper towel and toilet paper in place?',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 3,
                'title' => '21. Are washrooms kept clean?',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 3,
                'title' => '22. Are water fountains kept clean?',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 3,
                'title' => '23. Do exhaust fans function correctly',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 3,
                'title' => '24. Are food preparation areas kept clean? i.e. staff rooms, gym kitchens',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 3,
                'title' => 'Classrooms, Gymnasiums, Library’s',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 3,
                'title' => '25. Are all electrical switches, cover plates and outlets in good condition?',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 3,
                'title' => '26. Do electrical outlets appear to be overloaded?',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 3,
                'title' => '27. Were all storage areas found to be well maintained and in good condition?',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 3,
                'title' => '28. Are all computer cabling and power bars secured to prevent a tripping hazard?',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 3,
                'title' => '29. Are all workstations, chairs and tables in good condition and are organized in a safe fashion?',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 3,
                'title' => 'Fire Protection, Emergency Precautions and Procedures',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 3,
                'title' => '30. Are ceilings and exit doors free of combustible materials?',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 3,
                'title' => '31. Are paper wall coverings within the fire Code? 20% Maximum',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 3,
                'title' => '32. Are fire exits free from obstruction?',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 3,
                'title' => '33. Are ventilation and heating ducts kept free and clear of any added on combustible materials?',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 3,
                'title' => '34. Are hallways free from items that may cause problems during evacuation? i.e. tables, chairs/other moveable items',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 3,
                'title' => '35. Are the hazardous material and fire safety binders in place and up to date?',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 3,
                'title' => '36. Are 6 fire drills conducted annually?',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 3,
                'title' => '37. Is the First aid book in the medical room?',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 3,
                'title' => '38. Are first aid attendant names posted?   *Prominent location',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 3,
                'title' => '39. Is there sufficient first aid equipment onsite?  ',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 3,
                'title' => '40. Are playground inspections up to date?',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 3,
                'title' => '41. Are all alarm systems working and verification up to date?',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 3,
                'title' => '42. Are Health and Safety Committee meeting minutes posted for the last 3 months?',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 3,
                'title' => '43. Are emergency exit diagrams posted in all classrooms?',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 3,
                'title' => '44. Are all materials stored no closer than 18 inches from a sprinkler head? *NO items within 18 inches of the ceiling or suspended from ceilings',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 4,
                'title' => '',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
        ]);
    }
}
