@extends('../layout')

@section('content')
    <div class="container">
        <form action="{{ route('forms.store') }}" method="post">
            @csrf
            <article class="container">
                <h1>Create a new Form</h1>
                <p>Here you can create new forms. Start with a title and description. If applicable, define a
                    recurrence for how
                    often
                    the form must be completed and who must complete the form. Add sections to break up the form!
                    You can always
                    edit it
                    again later</p>
                <div class="form-group">
                    <label for="form_title">Title</label>
                    <input class="form-control" type="text" name="form_title" placeholder="Title" required
                           value="{{ old('form_title') }}">
                </div>
                <div class="form-group">
                    <label for="form_description">Description</label>
                    <textarea class="form-control" name="form_description"
                              placeholder="Description">{{ old('form_description') }}</textarea>
                </div>
            </article>
            <article class="container">
                <h2>Defining Recurrences</h2>

                <p>This describes how often per time unit the form is required to be completed. For example, it can
                    be one time per month or six times per year. </p>
                <p><small><b>Note that July and August will be excluded from the year unless you specify otherwise
                            in the box below</b>
                    </small></p>
                <p><small><b>Note that if you do not specify a required recurrence, it will not be required to
                            complete by
                            any
                            employee, but will still be available to fill out and submit.</b></small></p>
                <div class="form-group row">
                    <input class="form-control col-md-2" type="number" name="rec_quantity" placeholder="Ex. 1"
                           value="{{ old('rec_quantity') }}">
                    <p> time(s) per </p>

                    <input class="form-control col-md-2" type="number" name="rec_repeat" placeholder="Ex. 2"
                           value="{{ old('rec_repeat') }}">

                    <select class="form-control col-md-2" name="rec_time_unit">
                        <option value="week(s)" @if (old('rec_time_unit') == "week(s)") {{ 'selected' }} @endif>
                            week(s)
                        </option>
                        <option value="month(s)" @if (old('rec_time_unit') == "month(s)") {{ 'selected' }} @endif>
                            month(s)
                        </option>
                        <option value="year(s)" @if (old('rec_time_unit') == "year(s)") {{ 'selected' }} @endif>
                            year(s)
                        </option>
                    </select>


                </div>
                <div class="form-group">
                    <input type="checkbox" name="full_year" @if (is_array(old('full_year'))) checked @endif>
                    <label for="full_year">Include July and August in the year?</label>
                </div>

                <div class="form-group">
                    <label for="required_role">Who is required to submit this form?</label>
                    <select class="form-control" name="required_role">
                        <option value="All Staff" @if (old('required_role') == "All Staff") {{ 'selected' }} @endif>
                            All staff
                        </option>
                        <option
                            value="Principals and Vice Principals" @if (old('required_role') == "Principals and Vice Principals") {{ 'selected' }} @endif>
                            Principals and Vice Principals
                        </option>
                    </select>
                </div>
            </article>

            <section>
                <h2>Adding Sections</h2>
                <p>Use sections to group your form fields! </p>

                <div id="sections">

                </div>
                <button class="btn btn-info" type="button" id="addSection">Add a Section</button>
            </section>

            <button class="btn btn-success" type="submit">Submit</button>
            <button class="btn btn-secondary" type="reset">Reset</button>

        </form>
    </div>
@endsection
