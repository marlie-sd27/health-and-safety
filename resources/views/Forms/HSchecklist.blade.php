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
        <div class="row">
            <article class="col-md">
                <h2>Joint Health and Safety Committee Members</h2>
                <div class="form-group">
                    <label for="admin_rep1">Admin Rep 1</label>
                    <input type="text" name="admin_rep1" placeholder="Admin Rep 1" class="form-control"/>
                </div>
                <div class="form-group">
                    <label>Admin Rep 2</label>
                    <input class="form-control" type="text" name="admin_rep2" placeholder="Admin Rep 1"/>
                </div>
                <div class="form-group">
                    <label>IOUE Rep</label>
                    <input class="form-control" type="text" name="ioue_rep" placeholder="IOUE Rep"/>
                </div>
                <div class="form-group">
                    <label>CCTA Rep</label>
                    <input class="form-control" type="text" name="ccta_rep" placeholder="CCTA Rep"/>
                </div>
            </article>

            <article class="col-md">
                <h2>First Aid Attendants</h2>
                <div class="form-group">
                    <label>Designate Name</label>
                    <input class="form-control" type="text" name="designate_name" placeholder="Designate Name"/>
                </div>
                <div class="form-group">
                    <label>Designate Location</label>
                    <input class="form-control" type="text" name="designate_location" placeholder="Designate Location"/>
                </div>
                <div class="form-group">
                    <label>Backup Name</label>
                    <input class="form-control" type="text" name="backup_name" placeholder="Backup Name"/>
                </div>
                <div class="form-group">
                    <label>Backup Location</label>
                    <input class="form-control" type="text" name="backup_location" placeholder="Backup Location"/>
                </div>
            </article>
        </div>
        <div class="row">
            <article>
                <h2>Forms required to be on hand (in the office of first Aid Room)</h2>
                <div class="col-md">
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="injury_report_form_6A"/>
                            Injury Report Form 6A
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="first_aid_record_form"/>
                            First Aid Record Form
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="incident_investigation_form"/>
                            Incident Investigation Form
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="new_worker_site_orientation_form"/>
                            New Worker Site Orientation Form
                        </label>
                    </div>
                </div>
                <div class="col-md">
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="master_school_inspection_checklist"/>
                            Master School Inspection Checklist
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="risk_assessment_form"/>
                            Risk Assessment Form
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="chemical_storage_checklist"/>
                            Chemical Storage Checklist
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="indoor_air_quality_complaint_form"/>
                            Indoor Air Quality Complaint Form
                        </label>
                    </div>
                </div>
            </article>
        </div>
    </div>
@endsection
