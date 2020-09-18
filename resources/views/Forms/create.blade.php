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
                    again later.</p>
                <p><b>Newly created forms will go live right away. If you want to disable them, toggle the "live" switch
                        on the menu to index forms.</b></p>
                <div class="form-group">
                    <label for="form_title"><span class="required">*</span>Title</label>
                    <input class="form-control @error('title') border-danger @enderror" type="text" name="form_title" placeholder="Title" required
                           value="{{ old('title') }}">
                    @error('title')
                    <p class="text-danger">{{ $errors->first('title') }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="form_description">Description</label>
                    <textarea class="form-control @error('description') border-danger @enderror" name="form_description"
                              placeholder="Description">{{ old('description') }}</textarea>
                    @error('description')
                    <p class="text-danger">{{ $errors->first('description') }}</p>
                    @enderror
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
                <input class="form-control @error('first_occurence_at') border-danger @enderror"
                       type="text"
                       name="first_occurence_at"
                       placeholder="Pick a date"
                       value="{{ old('first_occurence_at') }}">

                @error('first_occurence_at')
                <p class="text-danger">{{ $errors->first('first_occurence_at') }}</p>
                @enderror
                <div class="form-group">
                    <label for="interval">Define a recurrence interval for the due dates</label>
                    <p><small>Examples: '1 year' or '3 months' or '1 month 2 weeks'</small></p>
                    <input class="form-control @error('interval') border-danger @enderror"
                           type="text"
                           name="interval"
                           placeholder="Define an interval"
                           value="{{ old('interval') }}">
                    @error('interval')
                    <p class="text-danger">{{ $errors->first('interval') }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="checkbox"
                           class="@error('full_year') border-danger @enderror"
                           name="full_year"
                           @if (old('full_year')) checked @endif>
                    <label for="full_year">Include July and August for scheduling?</label>
                    <p><small><b>Note that due dates will not be scheduled in July or August unless otherwise specified</b>
                        </small></p>
                    @error('full_year')
                    <p class=" text-danger">{{ $errors->first('full_year') }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="required_for"><span class="required">*</span>Who is required to submit this form?</label>
                    <select class="form-control @error('required_for') border-danger @enderror" name="required_for">
                        <option value="All Staff" @if (old('required_for') == "All Staff") {{ 'selected' }} @endif>
                            All Staff
                        </option>
                        <option
                            value="Principals and Vice Principals" @if (old('required_for') == "Principals and Vice Principals") {{ 'selected' }} @endif>
                            Principals and Vice Principals
                        </option>
                        <option
                            value="Secondary Principals Only" @if (old('required_for') == "Secondary Principals Only") {{ 'selected' }} @endif>
                            Secondary Principals Only
                        </option>
                        <option
                            value="Elementary Principals Only" @if (old('required_for') == "Secondary Principals Only") {{ 'selected' }} @endif>
                            Elementary Principals Only
                        </option>
                    </select>
                    @error('required_for')
                    <p class=" text-danger">{{ $errors->first('required_for') }}</p>
                    @enderror
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
