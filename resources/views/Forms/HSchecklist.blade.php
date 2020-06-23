@extends('layout')

@section('content')
    <div class="container">
        <h1> Health and Safety Start of Year Checklist</h1>
        <p>
            September is a very busy time for school districts. Maintenance is trying to wrap up any summer work and
            schools are trying to settle into a new school year.
            As a result it is easy to lose track of things that require completion.
            This checklist has been designed to ensure that all of our worksites are prepared, in terms of health and
            safety, for another school year.
        </p>
        <p>
            Within the first week of school First Aid Attendants and Joint Health and Safety Committee representatives
            need to be selected and designated.
            This should preferably happen during the first staff meeting at the same time as all of the information
            below is discussed with staff
        </p>
        <p>
            <b>
                Please complete this checklist and return via email to sd27maintenance@sd27.bc.ca by September 30th
            </b>
        </p>
        <article>
            <h2>Joint Health and Safety Committee Members</h2>
            <p>
                <label>
                    Admin Rep 1
                    <input type="text" name="admin_rep1" placeholder="Admin Rep 1"/>
                </label>
            </p>
            <p>
                <label>
                    Admin Rep 2
                    <input type="text" name="admin_rep2" placeholder="Admin Rep 1"/>
                </label>
            </p>
            <p>
                <label>
                    IOUE Rep
                    <input type="text" name="ioue_rep" placeholder="IOUE Rep"/>
                </label>
            </p>
            <p>
                <label>CCTA Rep
                    <input type="text" name="ccta_rep" placeholder="CCTA Rep"/>
                </label>
            </p>
        </article>

        <article>
            <h2>First Aid Attendants</h2>
            <p>
                <label>
                    Designate
                    <input type="text" name="designate_name" placeholder="Designate Name"/>
                    <input type="text" name="designate_location" placeholder="Designate Location"/>
                </label>
            </p>
            <p>
                <label>
                    Backup
                    <input type="text" name="backup_name" placeholder="Backup Name"/>
                    <input type="text" name="backup_location" placeholder="Backup Location"/>
                </label>
            </p>
        </article>

        <article>
            <h2>Forms required to be on hand (in the office of first Aid Room)</h2>
            <p>
                <label>
                    <input type="checkbox" name="injury_report_form_6A"/>
                    Injury Report Form 6A
                </label>
            </p>
            <p>
                <label>
                    <input type="checkbox" name="first_aid_record_form"/>
                    First Aid Record Form
                </label>
            </p>
            <p>
                <label>
                    <input type="checkbox" name="incident_investigation_form"/>
                    Incident Investigation Form
                </label>
            </p>
        </article>
    </div>
@endsection
