@extends('../layout')

@section('content')

    <a href="{{ url()->previous() }}">Back</a>
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

                <p><small><b>Note that if you do not specify a required recurrence, it will not be required to
                            complete by
                            any
                            employee, but will still be available to fill out and submit.</b></small></p>
                <div class="form-group">
                    <label for="first_occurence_at">Select one or more due dates</label>
                    <input class="form-control date" type="text" name="first_occurence_at" placeholder="Pick a date"
                           value="{{ old('first_occurence_at') }}">
                </div>
                <div class="form-group">
                    <label for="interval">Define a recurrence interval for the due dates</label>
                    <p><small>Examples: '1 year' or '3 months' or '1 month 2 weeks'</small></p>
                    <input class="form-control" type="text" name="interval" placeholder="Define an interval"
                           value="{{ old('interval') }}">
                </div>
                <div class="form-group">
                    <input type="checkbox" name="full_year" @if (is_array(old('full_year'))) checked @endif>
                    <label for="full_year">Include July and August for scheduling?</label>
                    <p><small><b>Note that due dates will not be scheduled in July or August unless otherwise specified</b>
                        </small></p>
                </div>

                <div class="form-group">
                    <label for="required_for">Who is required to submit this form?</label>
                    <select class="form-control" name="required_for">
                        <option value="All Staff" @if (old('required_for') == "All Staff") {{ 'selected' }} @endif>
                            All staff
                        </option>
                        <option
                            value="Principals and Vice Principals" @if (old('required_for') == "Principals and Vice Principals") {{ 'selected' }} @endif>
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

            <hr>

            <div class="container align-content-center">
                <button class="btn btn-block btn-lg btn-success" type="submit">Submit</button>
                <button class="btn btn-block btn-lg btn-secondary" type="reset">Reset</button>
            </div>
        </form>
@endsection
