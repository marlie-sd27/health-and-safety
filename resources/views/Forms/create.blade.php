@extends('../layout')

@section('content')
<div class="container">

    <h1>Create a new Form</h1>
    <p>Here you can create new forms. Start with a title and description. If applicable, define a recurrence for how
        often
        the form must be completed and who must complete the form. Add sections to break up the form! You can always
        edit it
        again later</p>
    <form action="/forms" method="post">
        @csrf
        <div class="form-group">
            <label for="form_title">Title</label>
            <input class="form-control" type="text" name="form_title" placeholder="Title" required>
        </div>
        <div class="form-group">
            <label for="form_description">Description</label>
            <textarea class="form-control" type="text" name="form_description" placeholder="Description"></textarea>
        </div>
        <div>
            <h2>Defining Recurrences</h2>
            <p>This describes how often per time unit the form is required to be completed. For example, it can be one
                time
                per month or six times per year. </p>
            <p><small><b>Note that July and August will be excluded from the year unless you specify otherwise in the
                        box
                        below</b>
                </small></p>
            <p><small><b>Note that if you do not specify a required recurrence, it will not be required to complete by
                        any
                        employee, but will still be available to fill out and submit.</b></small></p>
            <div class="form-group row">
                <input class="form-control col-md-2" type="number" name="rec_quantity" placeholder="Ex. 1">
                <p> time(s) per </p>

                <input class="form-control col-md-2" type="number" name="rec_repeat" placeholder="Ex. 2">

                <select class="form-control col-md-2" type="number" name="rec_time_unit"
                        placeholder="Choose a unit of time">
                    <option>week(s)</option>
                    <option>month(s)</option>
                    <option>year(s)</option>
                </select>


            </div>
            <div class="form-group">
                <input type="checkbox" name="full_year">
                <label for="full_year">Include July and August in the year?</label>
            </div>
        </div>

        <div>
            <h2>Adding Sections</h2>
            <p>Use sections to group your form fields! </p>
            <div class="form-group">
                <label for="section_title">Title</label>
                <input class="form-control" type="text" name="section_title" placeholder="Title" required>
            </div>
            <div class="form-group">
                <label for="section_description">Description</label>
                <textarea class="form-control" type="text" name="section_description" placeholder="Description"></textarea>
            </div>

            <h3>Add fields to your section</h3>
            <div class="form-group">
                <label for="type">Label</label>
                <input class="form-control" type="text" name="label" placeholder="Label"/>
            </div>
            <div class="form-group">
                <input type="checkbox" name="required" placeholder="Label"/>
                <label for="required">Required?</label>
            </div>
            <div class="form-group">
                <label for="type">Type of Input</label><br/>
                <input type="radio" name="type" id="text"/>Single Line Text<br/>
                <input type="radio" name="type" id="textarea"/>Multi Line Text<br/>
                <input type="radio" name="type" id="number"/>Numeric<br>
                <input type="radio" name="type" id="radio"/>Radio Button<br>
                <input type="radio" name="type" id="checkbox"/>Checkboxes<br>
                <input type="radio" name="type" id="slider"/>Slider<br>
            </div>
        </div>

        <button class="btn btn-primary" type="submit">Submit</button>
        <button class="btn btn-secondary" type="reset">Reset</button>

    </form>
</div>
@endsection
