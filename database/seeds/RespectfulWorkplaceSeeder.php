<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RespectfulWorkplaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $form = DB::table('forms')->insertGetId([
            'title' => 'Respectful Workplace Training',
            'description' => "We all have the right to work in an environment that is respectful and a responsibility to treat everyone at work with consideration. A respectful workplace: " .
                "\n\nIs inclusive\nValues diversity\nClearly communicates expectations around behaviour" .
                "\nPromotes employee health and safety\nProvides resources and training to resolve disputes" .
                "\nStrives for improvement\nHas open channels of communication" .
                "\n\nThis course is part of School District #27 efforts towards continually improving our workplaces that align with our Core Operating Values of ".
                ": Respect - Responsibility - Kindness and Caring - Acceptance." .
                "\n\nCourse Objectives:" .
                "\n\n1) Identifying what bullying & harassment is & what it is not." .
                "\n2) What the law is on this topic and what does our district policy require." .
                "\n3) Respective Roles & Responsibilities." .
                "\n4) Reporting procedures.",
            'interval' => '1 year',
            'first_occurence_at' => '2020-09-30',
            'required_for' => 'All Principals and Vice Principals',
            'full_year' => false,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        $section = DB::table('sections')->insertGetId([
            'forms_id' => $form,
            'title' => '',
            'description' => "Please watch the video What Does Bullying and Harassment Mean for You and Your Workplace?" .
                " Copy and paste the following link \nhttps://www.youtube.com/watch?v=u7e2c6v1oDs" .
                "\nFocus on the course objective of \n1a) What bullying and harassment are (at 28 sec) \n1b) What bullying and harassment are not (at 1:46), 2) The law (at 2:09)",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('fields')->insert([
            ['sections_id' => $section,
                'label' => 'I have completed watching the video',
                'name' => 'I have completed watching the video',
                'type' => 'radio',
                'required' => false,
                'options' => 'Yes',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
        ]);

        $section = DB::table('sections')->insertGetId([
            'forms_id' => $form,
            'title' => '',
            'description' => "Please view the PowerPoint: \nhttps://tinyurl.com/ycm5lgpr \nPlease focus on the course objectives: \n1) Slides 3 - 12 \n2) Slides 14 - 16 \n3) Slides 17 - 19 \n4) Slide 20",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('fields')->insert([
            ['sections_id' => $section,
                'label' => 'I have viewed the powerpoint',
                'name' => 'I have viewed the powerpoint',
                'type' => 'radio',
                'required' => false,
                'options' => 'Yes',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
        ]);

        $section = DB::table('sections')->insertGetId([
            'forms_id' => $form,
            'title' => '',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('fields')->insert([
            ['sections_id' => $section,
                'label' => 'What are some examples of bullying?',
                'name' => 'What are some examples of bullying?',
                'type' => 'radio',
                'required' => false,
                'options' => ' Abusive or offensive language; insults; ridicule; sarcasm or intimidating remarks, Deliberately excluding someone from work-related/study-related events or social activities or networks, Inappropriately threatening a student with low grades or a staff member with dismissal or disciplinary action or demotion, Subjecting a person to constant surveillance or over-detailed supervision and unwarranted checking of performance, All of the above, Some of the above',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['sections_id' => $section,
                'label' => 'What is not workplace bullying.  Check all that apply',
                'name' => 'What is not workplace bullying.  Check all that apply',
                'type' => 'checkbox',
                'required' => false,
                'options' => ' Setting reasonable performance goals and standards and deadlines, Informing a worker of their unsatisfactory performance, Informing a worker of their unreasonable or inappropriate behavior in an objective and confidential way, Making a complaint about a managers or another employee’s conduct, A workplace conflict e.g. a difference of opinion or a disagreement',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['sections_id' => $section,
                'label' => 'What is our duty of care in relation to bullying and harassment?',
                'name' => 'What is our duty of care in relation to bullying and harassment?',
                'type' => 'radio',
                'required' => false,
                'options' => ' It is the employers duty to ensure that all staff are not bullied or harassed, Each member of the organization has to take care of themselves, It is the responsibility of both the employer and all employees to ensure a bullying and harassment free environment',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['sections_id' => $section,
                'label' => 'How will I know if I am being bullied?  Does someone: (check all that could possibly apply)',
                'name' => 'How will I know if I am being bullied?  Does someone: (check all that could possibly apply)',
                'type' => 'radio',
                'required' => false,
                'options' => ' My work is constantly undermined and/or belittled, I have been given impossible deadlines to meet, I am constantly excluded from organizational meetings, I have been humiliated in front of my colleagues, I have been physically or verbally threatened',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['sections_id' => $section,
                'label' => 'What is your responsibility if you witness bullying?',
                'name' => 'What is your responsibility if you witness bullying?',
                'type' => 'radio',
                'required' => false,
                'options' => 'Leave it up to the individual because who knows how they feel. Maybe they dont feel bullied, Tell the person to report it, Tell another co-worker to see if it should be reported?, Fill out the SD #27 form "Workplace Bulling and Harassment"',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['sections_id' => $section,
                'label' => 'What can I do if I am accused of bullying or harassment?',
                'name' => 'What can I do if I am accused of bullying or harassment?',
                'type' => 'radio',
                'required' => false,
                'options' => ' Tell the person to "suck it up" and tell them they are too soft, Listen carefully and seek clarification on the behaviour that has been considered unacceptable. If needed ask for a break or time to consider your response; and if needed apologize for any offence',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['sections_id' => $section,
                'label' => 'How do I make a complaint if I am bullied?',
                'name' => 'How do I make a complaint if I am bullied?',
                'type' => 'radio',
                'required' => false,
                'options' => ' Tell my co-workers, Fill out SD #27 form "Workplace Bullying and Harassment" and submit it to either your supervisor or to the Manager of HR',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
            ['sections_id' => $section,
                'label' => 'Workplace bullying and harassment can be:',
                'name' => 'Workplace bullying and harassment can be:',
                'type' => 'radio',
                'required' => false,
                'options' => ' Directed towards a colleague, Directed towards a subordinate, Directed towards a manager or supervisor, Between an worker and non-worker (such as a parent), Between workers from different organizations (such as those at a worksite where employees from multiple organizations are working together), By a group of people or one individual towards another person or group, All of the above',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),],
        ]);
    }
}
