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
                'events_id' => 48,
                'site' => 'Cataline',
                'email' => 'marlie.teacher@sd27.bc.ca',
                'data' => 'Date=2020-07-21&Management+Rep=Cindy+Outhouse&Employee+Rep=Larry+King&Any+Outstanding+Actions+from+Previous+Inspection%3F=No&Has+the+last+inspection+been+reviewed+by+JOHS+Committee%3F=Yes&Are+all+handrails+in+place%2C+and+in+good+order%3F=Yes&Action+1=&By+Whom+1=&Date+Completed+1=&Is+siding+and+paint+in+good+condition%3F=No&Action+2=Repainted+the+siding&By+Whom+2=Marlie+Dueck&Date+Completed+2=2020-08-19&Action+3=&By+Whom+3=&Date+Completed+3=&Action+4=&By+Whom+4=&Date+Completed+4=&Are+driveways+and+parking+lots+in+good+condition%3F=Yes&Action+5=&By+Whom+5=&Date+Completed+5=&Are+playfields+in+good+condition%3F=Yes&Action+6=&By+Whom+6=&Date+Completed+6=&Are+outside+walkways+and+parking+lot+in+good+repair%3F=No&Action+7=Grated+the+parking+lot+to+smooth+out+potholes&By+Whom+7=Ryan+Andres&Date+Completed+7=2020-08-16&In+winter%2C+are+sidewalks+sufficiently+cleared+and+salted%2Fsanded%3F=N%2FA&Action+8=&By+Whom+8=&Date+Completed+8=&Are+play+structures+in+good+condition%3F=Yes&Action+9=&By+Whom+9=&Date+Completed+9=&Are+garbage+facilities+in+good+shape+and+locked%3F=Yes&Action+10=&By+Whom+10=&Date+Completed+10=&Do+all+exit+doors+work+properly%3F=Yes&Action+11=&By+Whom+11=&Date+Completed+11=&Exit+signs+%E2%80%93+are+they+illuminated%3F=Yes&Action+12=&By+Whom+12=&Date+Completed+12=&Are+stairways+in+good+repair%3F=Yes&Action+13=&By+Whom+13=&Date+Completed+13=&Are+stairways+clear+of+any+material+that+may+cause+tripping+hazard%3F=Yes&Action+14=&By+Whom+14=&Date+Completed+14=&Are+all+ceiling+tiles+in+place+and+in+good+condition%3F=Yes&Action+15=&By+Whom+15=&Date+Completed+15=&Are+hallways+clear+from+clutter+that+may+cause+a+tripping+hazard+or+disrupt+orderly+evacuation%3F=Yes&Action+16=&By+Whom+16=&Date+Completed+16=&Are+all+cabinetry%2C+stalls%2C+mirrors+and+fixtures+in+good+condition%3F=Yes&Action+17=&By+Whom+17=&Date+Completed+17=&Are+mats+and+gratings+in+good+repair%3F=Yes&Action+18=&By+Whom+18=&Date+Completed+18=&Do+all+electrical+panels+have+1M+clearance+in+front+of+them%3F=Yes&Action+19=&By+Whom+19=&Date+Completed+19=&Are+paper+towel+and+toilet+paper+in+place%3F=No&Action+20=Put+in+proper+paper+towel+and+toilet+paper&By+Whom+20=Vicki+Elzinga&Date+Completed+20=2020-08-13&Are+washrooms+kept+clean%3F=Yes&Action+21=&By+Whom+21=&Date+Completed+21=&Are+water+fountains+kept+clean%3F=Yes&Action+22=&By+Whom+22=&Date+Completed+22=&Do+exhaust+fans+function+correctly=Yes&Action+23=&By+Whom+23=&Date+Completed+23=&Are+food+preparation+areas+kept+clean%3F+i.e.+staff+rooms%2C+gym+kitchens=Yes&Action+24=&By+Whom+24=&Date+Completed+24=',
                'created_at' => Carbon::create('2020', '09', '23', '12', '34'),
                'updated_at' => Carbon::create('2020', '09', '23', '12', '34'),
            ],
            [
                'forms_id' => 3,
                'events_id' => 48,
                'site' => 'Nesika',
                'email' => 'morgan.freeman@sd27.bc.ca',
                'data' => 'Date=2020-07-21&Management+Rep=Cindy+Outhouse&Employee+Rep=Larry+King&Any+Outstanding+Actions+from+Previous+Inspection%3F=No&Has+the+last+inspection+been+reviewed+by+JOHS+Committee%3F=Yes&Are+all+handrails+in+place%2C+and+in+good+order%3F=Yes&Is+siding+and+paint+in+good+condition%3F=Yes&Are+stairways+in+good+repair%3F=Yes',
                'created_at' => Carbon::create('2020', '09', '29', '12', '00'),
                'updated_at' => Carbon::create('2020', '09', '29', '12', '00'),
            ],
            [
                'forms_id' => 3,
                'events_id' => 48,
                'site' => 'Marie Sharpe',
                'email' => 'oprah.winfrey@sd27.bc.ca',
                'data' => 'Date=2020-07-21&Management+Rep=Cindy+Outhouse&Employee+Rep=Larry+King&Any+Outstanding+Actions+from+Previous+Inspection%3F=No&Has+the+last+inspection+been+reviewed+by+JOHS+Committee%3F=Yes&Are+all+handrails+in+place%2C+and+in+good+order%3F=Yes&Is+siding+and+paint+in+good+condition%3F=Yes&Are+stairways+in+good+repair%3F=Yes',
                'created_at' => Carbon::create('2020', '09', '28', '12', '00'),
                'updated_at' => Carbon::create('2020', '09', '28', '12', '00'),
            ],
            [
                'forms_id' => 2,
                'events_id' => 38,
                'site' => 'Maintenance Yard',
                'email' => 'alex.trebek@sd27.bc.ca',
                'data' => 'Admin+Rep+1=Ken+Matieshen&Admin+Rep+2=Dave+Corbett&IUOE+Rep=John+Doe&CCTA+Rep=Jane+Doe&Designate+Name=Ryan+Andres&Designate+Location=Maintenance+Yard&Backup+Name=Barry+Rawlek&Backup+Location=Maintenance+Yard&Forms+Required+to+be+on+hand+%28in+office+of+First+Aid+Room%29%5B+Injury+Report+Form+6a%5D=on&Forms+Required+to+be+on+hand+%28in+office+of+First+Aid+Room%29%5B+First+aid+Record+Form%5D=on&Forms+Required+to+be+on+hand+%28in+office+of+First+Aid+Room%29%5B+Incident+Investigation+Form%5D=on&Forms+Required+to+be+on+hand+%28in+office+of+First+Aid+Room%29%5B+New+Worker+Site+Orientation+Form%5D=on&Health+and+Safety+Notice+Board+%28this+information+must+be+posted%29%5B+JOHS+Committee+names+and+locations%5D=on&Health+and+Safety+Notice+Board+%28this+information+must+be+posted%29%5B+Previous+3+months+of+JOHS+Committee+minutes%5D=on&Instructed+staff+on+how+to+access+Safety+Data+Sheets=No&Reviewed+relevant+Safe+Work+Procedures+with+staff=No&Conducted+Site+Orientations+for+any+new+school+staff=Yes&Reviewed+district+Working+Alone+Program+with+staff=Yes&Signature+of+Principal%2FSupervisor=Marlie+Dueck&Date=2020-07-21',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'forms_id' => 1,
                'events_id' => 2,
                'site' => 'Cataline',
                'email' => 'marlie.teacher@sd27.bc.ca',
                'data' => 'Date=2020-07-22&Name+of+Principal=Mike+Grace&Total+Enrollment=700&Date+of+Fire+Drill=2020-07-20&Precise+time+of+Fire+Drill=09%3A15&Time+taken+to+Evacuate=8+minutes&Comments=&Signed=Marlie+Dueck&Title=IT',
                'created_at' => Carbon::create('2020', '10', '10', '15'),
                'updated_at' => Carbon::create('2020', '10', '10', '15'),
            ],
            [
                'forms_id' => 1,
                'events_id' => 8,
                'site' => 'Cataline',
                'email' => 'marlie.teacher@sd27.bc.ca',
                'data' => 'Date=2020-07-22&Name+of+Principal=Mike+Grace&Total+Enrollment=700&Date+of+Fire+Drill=2020-07-20&Precise+time+of+Fire+Drill=09%3A15&Time+taken+to+Evacuate=8+minutes&Comments=&Signed=Marlie+Dueck&Title=IT',
                'created_at' => Carbon::create('2020', '11', '10', '15'),
                'updated_at' => Carbon::create('2020', '11', '10', '15'),
            ],
            [
                'forms_id' => 1,
                'events_id' => 2,
                'site' => 'Nesika',
                'email' => 'morgan.freeman@sd27.bc.ca',
                'data' => 'Date=2020-07-22&Name+of+Principal=Mike+Grace&Total+Enrollment=700&Date+of+Fire+Drill=2020-07-20&Precise+time+of+Fire+Drill=09%3A15&Time+taken+to+Evacuate=8+minutes&Comments=&Signed=Marlie+Dueck&Title=IT',
                'created_at' => Carbon::create('2020', '10', '8', '15'),
                'updated_at' => Carbon::create('2020', '10', '10', '15'),
            ],
            [
                'forms_id' => 1,
                'events_id' => 8,
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
