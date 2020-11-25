@extends('../layout')

@section('content')

    <a href="{{ route('forms.show', ['form' => $form->id]) }}">Back</a>
    <div class="container">
        <h1>Edit</h1>
        <div class="alert alert-danger">
            <p>
                WARNING: Edit form fields with caution! <b>Any changes may cause gaps in data of previous
                    submissions</b>.
                It is recommended to only edit the form title, description and "Defining Recurrences" section.
            </p>
        </div>
        <form action="{{ route('forms.update', ['form' => $form->id ]) }}" method="post">
            @method('PUT')
            @csrf
            <article class="container">
                <div class="form-group">
                    <label for="form_title"><span class="required">*</span>Title</label>
                    <input class="form-control @error('title') border-danger @enderror"
                           type="text"
                           name="form_title"
                           value="@if (old('form_title')){{ old('form_title') }}@else {{ $form->title }} @endif"
                           required
                    />
                    @error('title')
                    <p class="text-danger">{{ $errors->first('title') }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="form_description">Description</label>
                    <textarea class="form-control @error('form_description') border-danger @enderror"
                              name="form_description">@if(old('form_description')){{old('form_description')}}@else{{$form->description}}@endif</textarea>
                    @error('form_description')
                    <p class="text-danger">{{ $errors->first('form_description') }}</p>
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
                <div class="form-group">
                    <label for="first_occurence_at">Enter one or more due dates separated by a comma</label>
                    <p><small>Examples: '2020-09-01,2020-12-01' or '2020-10-30'. Dates must be in the format yyyy-mm-dd. Leave blank for no due dates</small></p>
                    <input class="form-control @error('first_occurence_at') border-danger @enderror"
                           type="text"
                           name="first_occurence_at"
                           placeholder="Pick a date"
                           value="@if (old('first_occurence_at')){{ old('first_occurence_at') }}@else{{ $form->first_occurence_at }}@endif">

                    @error('first_occurence_at')
                        <p class=" text-danger">{{ $errors->first('first_occurence_at') }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="interval">Define a recurrence interval for the due dates</label>
                    <p><small>Examples: '1 year' or '3 months' or '1 month 2 weeks'</small></p>
                    <input class="form-control @error('interval') border-danger @enderror"
                           type="text"
                           name="interval"
                           placeholder="Define an interval"
                           value="@if (old('interval')){{ old('interval') }}@else{{ $form->interval }}@endif">
                    @error('interval')
                        <p class=" text-danger">{{ $errors->first('interval') }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="checkbox"
                           class="@error('full_year') border-danger @enderror"
                           name="full_year" @if ($form->full_year | is_array(old('full_year'))) checked @endif>
                    <label for="full_year">Include July and August for scheduling?</label>
                    @error('full_year')
                        <p class=" text-danger">{{ $errors->first('full_year') }}</p>
                    @enderror
                    <p><small><b>Note that due dates will not be scheduled in July or August unless otherwise specified</b>
                        </small></p>
                </div>
                <div class="form-group">
                    <label for="required_for"><span class="required">*</span>Who is required to submit this form?</label>
                    <select id="required_for"
                            class="form-control @error('required_for') border-danger @enderror"
                            name="required_for">
                        <option @if (old('required_for') == "" || $form->required_for == "") {{ 'selected' }} @endif></option>
                        <option @if (old('required_for') == "All Staff" || $form->required_for == "All Staff") {{ 'selected' }} @endif>All Staff</option>
                        <option @if (old('required_for') == "Specific Staff" || $form->required_for == "Specific Staff") {{ 'selected' }} @endif>Specific Staff</option>
                        <option @if (old('required_for') == "Specific Sites" || $form->required_for == "Specific Sites") {{ 'selected' }} @endif>Specific Sites</option>
                    </select>
                    @error('required_for')
                    <p class="text-danger">{{ $errors->first('required_for') }}</p>
                    @enderror
                </div>

                <div id="requirees_sites" class="{{ $form->required_for == 'Specific Sites' ? '' : 'd-none' }} form-group">
                    <label>Which sites would you like to make this due for?</label>
                    <button type="button"
                            class="help"
                            data-container="body"
                            data-toggle="popover"
                            data-placement="right"
                            data-content="The form will be required for each site to complete once per deadline. If somebody completes this form for a site, nobody else at that site is required to complete it.">
                        <b>?</b>
                    </button>
                    @foreach($sites as $site)
                        <p>
                            <label>
                                <input type="checkbox"
                                       class="@error('requirees_sites') border-danger @enderror"
                                       name="requirees_sites[]"
                                       value="{{ $site->id }}"/> {{$site->site}}
                           </label>
                        @error('requirees_sites')
                        <p class="text-danger">{{ $errors->first('requirees_sites') }}</p>
                        @enderror

                    @endforeach
                </div>

                <div id="requirees_emails" class="{{ $form->required_for == 'Specific Staff' ? '' : 'd-none' }} form-group">
                    <label>Which users would you like to make this due for? Separate emails with a comma</label>
                    <button type="button"
                            class="help"
                            data-container="body"
                            data-toggle="popover"
                            data-placement="right"
                            data-content="The form will be required for each user to complete once per deadline. ">
                        <b>?</b>
                    </button>
                    <textarea class="form-control @error('requirees_emails') border-danger @enderror"
                              name="requirees_emails">{{ old('requirees_emails') || $form->required_for == 'Specific Staff' ? $form->requirees : '' }}</textarea>
                    @error('requirees_emails')
                    <p class=" text-danger">{{ $errors->first('requirees_emails') }}</p>
                    @enderror
                </div>
            </article>

            <section>
                <h2>Adding Sections</h2>
                <p>Use sections to group your form fields! </p>

                <div id="sections">
                    @foreach($form->sections as $section)
                        <article>
                            <img id="removeSection" src="{{ asset('images/delete.png') }}" height="25em;" alt="remove"/>
                            <div class="toggle-expand">
                            </div>
                            <div class="container" id="section">
                                <input type="hidden" value="{{ $section->id }}" name="s_id[]"/>

                                <div class="form-group">
                                    <label for="section_title">Title</label>
                                    <input class="form-control @error("section_title.$loop->index") border-danger @enderror"
                                           type="text"
                                           name="section_title[]"
                                           value="@if (old("section_title.$loop->index")){{ old("section_title.$loop->index") }}@else{{ $section->title }} @endif">
                                    @error("section_title.$loop->index")
                                        <p class=" text-danger">{{ $errors->first("section_title.$loop->index") }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="section_description">Description</label>
                                    <textarea class="form-control @error("section_description.$loop->index") border-danger @enderror"
                                              name="section_description[]">@if (old("section_description[$loop->index]")){{ old("section_description[$loop->index]") }}@else{{ $section->description }}@endif</textarea>
                                    @error("section_description.$loop->index")
                                        <p class=" text-danger">{{ $errors->first("section_description.$loop->index") }}</p>
                                    @enderror
                                </div>
                                <h3>Add fields to your section</h3>
                                <div id="fields">
                                    @foreach($section->fields as $field)
                                        <article>
                                            <img id="removeField" src="{{ asset('images/delete.png') }}" height="25em;"
                                                 alt="remove"/>
                                            <div class="toggle-expand">
                                            </div>
                                            <div class="container">
                                                <input type="hidden" name="section_id[]"
                                                       value="{{ $field->sections_id }}"/>
                                                <input type='hidden' name="field_name[]" value="{{ $field->name }}"/>
                                                <div class="form-group">
                                                    <label for="type"><span class="required">*</span>Label</label>
                                                    <input class="form-control @error("label.$loop->index") border-danger @enderror"
                                                           type="text"
                                                           name="label[]"
                                                           value="@if (old("label.$loop->index")){{ old("label.$loop->index") }}@else{{ $field->label }}@endif"/>
                                                    @error("label.$loop->index")
                                                        <p class=" text-danger">{{ $errors->first("label.$loop->index") }}</p>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="help[]">Help Description (optional)</label>
                                                    <button type="button"
                                                        class="help"
                                                        data-container="body"
                                                        data-toggle="popover"
                                                        data-placement="right"
                                                            data-content="A help description looks just like this! It\'ll be right beside the field and give your users more clarification as to what this field is.">
                                                        <b>?</b>
                                                    </button>
                                                    <input class="form-control"
                                                           type="text"
                                                           name="help[]"
                                                           placeholder="Help Description"
                                                           value="@if (old("help.$loop->index")){{ old("help.$loop->index") }}@else{{ $field->help }}@endif"/>
                                                    @error("help.$loop->index")
                                                        <p class=" text-danger">{{ $errors->first("help.$loop->index") }}</p>
                                                    @enderror
                                                    </div>
                                                <div class="form-group">
                                                    <input type="checkbox"
                                                           name="required[{{ $field->id }}]" {{ $field->required ? "checked" : "" }}
                                                    />
                                                    <label for="required">Required?</label>
                                                </div>
                                                <div class="form-group">
                                                    <label for="type">Type of Input</label><br/>
                                                    <select class="form-control" name="type[]" id="type">
                                                        <option
                                                            value="text" @if ($field->type == "text") {{ 'selected' }} @endif>
                                                            Single Line Text
                                                        </option>
                                                        <option
                                                            value="textarea" @if ($field->type == "textarea") {{ 'selected' }} @endif>
                                                            Multi Line Text
                                                        </option>
                                                        <option
                                                            value="select" @if ($field->type == "select") {{ 'selected' }} @endif>
                                                            Drop Down Menu
                                                        </option>
                                                        <option
                                                            value="number" @if ($field->type == "number") {{ 'selected' }} @endif>
                                                            Numeric
                                                        </option>
                                                        <option
                                                            value="radio" @if ($field->type == "radio") {{ 'selected' }} @endif>
                                                            Radio Button
                                                        </option>
                                                        <option
                                                            value="checkbox" @if ($field->type == "checkbox") {{ 'selected' }} @endif>
                                                            Checkboxes
                                                        </option>
                                                        <option
                                                            value="slider" @if ($field->type == "slider") {{ 'selected' }} @endif>
                                                            Slider
                                                        </option>
                                                        <option
                                                            value="date" @if ($field->type == "date") {{ 'selected' }} @endif>
                                                            Date
                                                        </option>
                                                        <option
                                                            value="time" @if ($field->type == "time") {{ 'selected' }} @endif>
                                                            Time
                                                        </option>
                                                        <option
                                                            value="file" @if ($field->type == "file") {{ 'selected' }} @endif>
                                                            File Upload
                                                        </option>
                                                    </select></div>
                                                <div id="options" class="{{ $field->options !== "" ? "" : "d-none" }}">
                                                    <input type="hidden" name="field_id[]" value="{{ $field->id }}"/>
                                                    <label for="options[]">Options (enter each option separated by a
                                                        comma)</label>
                                                    <input type="text" name="options[]" class="form-control"
                                                           value="{{ $field->options !== "" ? join(",", $field->options) : "" }}"/>
                                                </div>
                                            </div>
                                        </article>
                                    @endforeach
                                </div>

                                <button class="btn btn-info" id="addField" type="button">Add Field</button>
                            </div>
                        </article>
                    @endforeach
                </div>
                <button class="btn btn-info" type="button" id="addSection">Add a Section</button>
            </section>

            <hr>

            <div class="container align-content-center">
                <button class="btn btn-block btn-lg btn-success" type="submit">Save</button>
            </div>
        </form>
    </div>
@endsection
