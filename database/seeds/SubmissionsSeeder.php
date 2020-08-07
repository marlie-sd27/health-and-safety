<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubmissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('submissions')->insert([
            [
                'forms_id' => 3,
                'events_id' => 43,
                'site' => 'Cataline',
                'email' => 'marlie.teacher@sd27.bc.ca',
                'data' => 'Date=2020-07-21&Management+Rep=Cindy+Outhouse&Employee+Rep=Larry+King&Any+Outstanding+Actions+from+Previous+Inspection%3F=No&Has+the+last+inspection+been+reviewed+by+JOHS+Committee%3F=Yes&Are+all+handrails+in+place%2C+and+in+good+order%3F=Yes&Is+siding+and+paint+in+good+condition%3F=Yes&Are+stairways+in+good+repair%3F=Yes',
                'created_at' => Carbon::create('2020', '09', '23', '12', '34'),
                'updated_at' => Carbon::create('2020', '09', '23', '12', '34'),
            ],
            [
                'forms_id' => 3,
                'events_id' => 43,
                'site' => 'Nesika',
                'email' => 'morgan.freeman@sd27.bc.ca',
                'data' => 'Date=2020-07-21&Management+Rep=Cindy+Outhouse&Employee+Rep=Larry+King&Any+Outstanding+Actions+from+Previous+Inspection%3F=No&Has+the+last+inspection+been+reviewed+by+JOHS+Committee%3F=Yes&Are+all+handrails+in+place%2C+and+in+good+order%3F=Yes&Is+siding+and+paint+in+good+condition%3F=Yes&Are+stairways+in+good+repair%3F=Yes',
                'created_at' => Carbon::create('2020', '09', '29', '12', '00'),
                'updated_at' => Carbon::create('2020', '09', '29', '12', '00'),
            ],
            [
                'forms_id' => 3,
                'events_id' => 43,
                'site' => 'Marie Sharpe',
                'email' => 'oprah.winfrey@sd27.bc.ca',
                'data' => 'Date=2020-07-21&Management+Rep=Cindy+Outhouse&Employee+Rep=Larry+King&Any+Outstanding+Actions+from+Previous+Inspection%3F=No&Has+the+last+inspection+been+reviewed+by+JOHS+Committee%3F=Yes&Are+all+handrails+in+place%2C+and+in+good+order%3F=Yes&Is+siding+and+paint+in+good+condition%3F=Yes&Are+stairways+in+good+repair%3F=Yes',
                'created_at' => Carbon::create('2020', '09', '28', '12', '00'),
                'updated_at' => Carbon::create('2020', '09', '28', '12', '00'),
            ],
            [
                'forms_id' => 2,
                'events_id' => 37,
                'site' => 'Maintenance Yard',
                'email' => 'alex.trebek@sd27.bc.ca',
                'data' => 'Admin+Rep+1=Ken+Matieshen&Admin+Rep+2=Dave+Corbett&IUOE+Rep=John+Doe&CCTA+Rep=Jane+Doe&Designate+Name=Ryan+Andres&Designate+Location=Maintenance+Yard&Backup+Name=Barry+Rawlek&Backup+Location=Maintenance+Yard&Forms+Required+to+be+on+hand+%28in+office+of+First+Aid+Room%29%5B+Injury+Report+Form+6a%5D=on&Forms+Required+to+be+on+hand+%28in+office+of+First+Aid+Room%29%5B+First+aid+Record+Form%5D=on&Forms+Required+to+be+on+hand+%28in+office+of+First+Aid+Room%29%5B+Incident+Investigation+Form%5D=on&Forms+Required+to+be+on+hand+%28in+office+of+First+Aid+Room%29%5B+New+Worker+Site+Orientation+Form%5D=on&Health+and+Safety+Notice+Board+%28this+information+must+be+posted%29%5B+JOHS+Committee+names+and+locations%5D=on&Health+and+Safety+Notice+Board+%28this+information+must+be+posted%29%5B+Previous+3+months+of+JOHS+Committee+minutes%5D=on&Instructed+staff+on+how+to+access+Safety+Data+Sheets=No&Reviewed+relevant+Safe+Work+Procedures+with+staff=No&Conducted+Site+Orientations+for+any+new+school+staff=Yes&Reviewed+district+Working+Alone+Program+with+staff=Yes&Signature+of+Principal%2FSupervisor=Marlie+Dueck&Date=2020-07-21',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 1,
                'events_id' => 1,
                'site' => 'Cataline',
                'email' => 'marlie.teacher@sd27.bc.ca',
                'data' => 'Date=2020-07-22&Name+of+Principal=Mike+Grace&Total+Enrollment=700&Date+of+Fire+Drill=2020-07-20&Precise+time+of+Fire+Drill=09%3A15&Time+taken+to+Evacuate=8+minutes&Comments=&Signed=Marlie+Dueck&Title=IT',
                'created_at' => Carbon::create('2020', '10', '10', '15'),
                'updated_at' => Carbon::create('2020', '10', '10', '15'),
            ],
            [
                'forms_id' => 1,
                'events_id' => 7,
                'site' => 'Cataline',
                'email' => 'marlie.teacher@sd27.bc.ca',
                'data' => 'Date=2020-07-22&Name+of+Principal=Mike+Grace&Total+Enrollment=700&Date+of+Fire+Drill=2020-07-20&Precise+time+of+Fire+Drill=09%3A15&Time+taken+to+Evacuate=8+minutes&Comments=&Signed=Marlie+Dueck&Title=IT',
                'created_at' => Carbon::create('2020', '11', '10', '15'),
                'updated_at' => Carbon::create('2020', '11', '10', '15'),
            ],
            [
                'forms_id' => 1,
                'events_id' => 1,
                'site' => 'Nesika',
                'email' => 'morgan.freeman@sd27.bc.ca',
                'data' => 'Date=2020-07-22&Name+of+Principal=Mike+Grace&Total+Enrollment=700&Date+of+Fire+Drill=2020-07-20&Precise+time+of+Fire+Drill=09%3A15&Time+taken+to+Evacuate=8+minutes&Comments=&Signed=Marlie+Dueck&Title=IT',
                'created_at' => Carbon::create('2020', '10', '8', '15'),
                'updated_at' => Carbon::create('2020', '10', '10', '15'),
            ],
            [
                'forms_id' => 1,
                'events_id' => 7,
                'site' => 'Nesika',
                'email' => 'morgan.freeman@sd27.bc.ca',
                'data' => 'Date=2020-07-22&Name+of+Principal=Mike+Grace&Total+Enrollment=700&Date+of+Fire+Drill=2020-07-20&Precise+time+of+Fire+Drill=09%3A15&Time+taken+to+Evacuate=8+minutes&Comments=&Signed=Marlie+Dueck&Title=IT',
                'created_at' => Carbon::create('2020', '11', '8', '15'),
                'updated_at' => Carbon::create('2020', '11', '10', '15'),
            ],
            [
                'forms_id' => 4,
                'events_id' => null,
                'site' => 'Maintenance Yard',
                'email' => 'marlie.student@sd27.bc.ca',
                'data' => 'Asbestos+fibres+can+cause=Asbestosis&Who+is+notified+in+case+of+an+asbestoss+spill%3F=Manager+of+Facilities+%26+Transportation&What+colour+is+the+Asbestos+Management+Plan+binder%3F=Black&Where+is+the+Asbestos+Management+Plan+located+at+your+site%3F=School+Office&What+is+the+Facilities+Manager+Responsibilities%3F=choose+the+OH%26S+team',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 4,
                'events_id' => null,
                'site' => 'Maintenance Yard',
                'email' => 'ryan.reynolds@sd27.bc.ca',
                'data' => 'Asbestos+fibres+can+cause=Asbestosis&Who+is+notified+in+case+of+an+asbestoss+spill%3F=Manager+of+Facilities+%26+Transportation&What+colour+is+the+Asbestos+Management+Plan+binder%3F=Black&Where+is+the+Asbestos+Management+Plan+located+at+your+site%3F=School+Office&What+is+the+Facilities+Manager+Responsibilities%3F=choose+the+OH%26S+team',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 4,
                'events_id' => null,
                'site' => 'Maintenance Yard',
                'email' => 'john.doe@sd27.bc.ca',
                'data' => 'Asbestos+fibres+can+cause=Asbestosis&Who+is+notified+in+case+of+an+asbestoss+spill%3F=Manager+of+Facilities+%26+Transportation&What+colour+is+the+Asbestos+Management+Plan+binder%3F=Black&Where+is+the+Asbestos+Management+Plan+located+at+your+site%3F=School+Office&What+is+the+Facilities+Manager+Responsibilities%3F=choose+the+OH%26S+team',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 4,
                'events_id' => null,
                'site' => 'Maintenance Yard',
                'email' => 'angelina.jolie@sd27.bc.ca',
                'data' => 'Asbestos+fibres+can+cause=Asbestosis&Who+is+notified+in+case+of+an+asbestoss+spill%3F=Manager+of+Facilities+%26+Transportation&What+colour+is+the+Asbestos+Management+Plan+binder%3F=Black&Where+is+the+Asbestos+Management+Plan+located+at+your+site%3F=School+Office&What+is+the+Facilities+Manager+Responsibilities%3F=choose+the+OH%26S+team',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],

        ]);
    }
}
