<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateFunction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('CREATE OR REPLACE FUNCTION insert_events_4()
                RETURNS TRIGGER AS $example_table$

                DECLARE
                    finish DATE := new.first_occurence_at + INTERVAL \'5 years\' ;
                    next_occurence DATE := new.first_occurence_at::DATE ;
                    month INTEGER ;

                BEGIN
                LOOP
                    EXIT WHEN next_occurence > finish;

                    IF new.full_year = \'f\'::BOOLEAN THEN
                        SELECT EXTRACT(MONTH FROM next_occurence) INTO month;

                        IF month = 7 THEN
                            RAISE NOTICE \'Not scheduling for July\';
                        ELSEIF month = 8 THEN
                            RAISE NOTICE \'Not scheduling for August\';
                        ELSE
                            INSERT INTO events (forms_id, date) VALUES (new.id, next_occurence);
                        END IF;

                        next_occurence := next_occurence + new.interval::INTERVAL;

                    ELSE
                        INSERT INTO events (forms_id, date) VALUES (new.id, next_occurence);
                        next_occurence := next_occurence + new.interval::INTERVAL;
                    END IF;

                END LOOP;
                RETURN NULL;
            END;
            $example_table$ LANGUAGE plpgsql;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP FUNCTION `insert_events_4`');
    }
}
