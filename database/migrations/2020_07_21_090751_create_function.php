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
        DB::unprepared('CREATE OR REPLACE FUNCTION insert_events()
    RETURNS TRIGGER AS $example_table$

    DECLARE
        schedule_dates DATE[];
        date DATE;
        finish DATE;
        next_occurence DATE;
        month INTEGER ;

    BEGIN

        IF (new.interval IS NOT NULL AND new.first_occurence_at IS NOT NULL) THEN

            SELECT string_to_array(new.first_occurence_at, \',\') INTO schedule_dates;

            FOREACH date IN ARRAY schedule_dates LOOP
                finish := date + INTERVAL \'5 years\';
                next_occurence := date::DATE;

                LOOP
                    EXIT WHEN next_occurence > finish;

                    IF new.full_year = \'f\'::BOOLEAN THEN
                        SELECT EXTRACT(MONTH FROM next_occurence) INTO month;

                        IF month = 7 THEN
                            RAISE NOTICE \'Not scheduling for July\';
                        ELSEIF month = 8 THEN
                            RAISE NOTICE \'Not scheduling for August\';
                        ELSE
                            INSERT INTO events (forms_id, date, created_at, updated_at)
                            VALUES (new.id, next_occurence, now(), now());
                        END IF;

                        next_occurence := next_occurence + new.interval::INTERVAL;

                    ELSE
                        INSERT INTO events (forms_id, date) VALUES (new.id, next_occurence);
                        next_occurence := next_occurence + new.interval::INTERVAL;
                    END IF;

                END LOOP;

            END LOOP;

        ELSEIF new.first_occurence_at IS NOT NULL THEN

            SELECT string_to_array(new.first_occurence_at, \',\') INTO schedule_dates;

            FOREACH date IN ARRAY schedule_dates LOOP
                INSERT INTO events (forms_id, date) VALUES (new.id, date::DATE);
            END LOOP;
        END IF;
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
        DB::unprepared('DROP FUNCTION `insert_events`');
    }
}
