@extends('../layout')

@section('content')

    <a href="{{ route('forms.show', ['form' => $form->id]) }}">Back</a>
    <div class="container">
        <h1>Edit</h1>
        <form action="{{ route('forms.update', ['form' => $form->id ]) }}" method="post">
            @method('PUT')
            @csrf
            <article class="container">
                <div class="form-group">
                    <label for="form_title">Title</label>
                    <input class="form-control" type="text" name="form_title" required value="{{ $form->title }}">
                </div>
                <div class="form-group">
                    <label for="form_description">Description</label>
                    <textarea class="form-control" name="form_description">{{ $form->description }}</textarea>
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
                <div class="form-group row container">
                    <input class="form-control col-md-2" type="number" name="rec_quantity"
                           value="{{ is_array($form->recurrence) ?  $form->recurrence[0] : null }}">
                    <p> time(s) per </p>

                    <input class="form-control col-md-2" type="number" name="rec_repeat"
                           value="{{ is_array($form->recurrence) ?  $form->recurrence[1] : null }}">

                    <select class="form-control col-md-2" name="rec_time_unit">
                        <option
                            value="week(s)" @if (is_array($form->recurrence) && $form->recurrence[2] == "week(s)") {{ 'selected' }} @endif>
                            week(s)
                        </option>
                        <option
                            value="month(s)" @if (is_array($form->recurrence) && $form->recurrence[2] == "month(s)") {{ 'selected' }} @endif>
                            month(s)
                        </option>
                        <option
                            value="year(s)" @if (is_array($form->recurrence) && $form->recurrence[2] == "year(s)") {{ 'selected' }} @endif>
                            year(s)
                        </option>
                    </select>


                </div>
                <div class="form-group">
                    <input type="checkbox" name="full_year" @if (is_array($form->full_year)) checked @endif>
                    <label for="full_year">Include July and August in the year?</label>
                </div>

                <div class="form-group">
                    <label for="required_for">Who is required to submit this form?</label>
                    <select class="form-control" name="required_for">
                        <option value="All Staff" @if ($form->required_for == "All Staff") {{ 'selected' }} @endif>
                            All staff
                        </option>
                        <option
                            value="Principals and Vice Principals" @if ($form->required_for == "Principals and Vice Principals") {{ 'selected' }} @endif>
                            Principals and Vice Principals
                        </option>
                    </select>
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
                                    <input class="form-control" type="text" name="section_title[]"
                                           value="{{ $section->title }}">
                                </div>
                                <div class="form-group">
                                    <label for="section_description">Description</label>
                                    <textarea class="form-control"
                                              name="section_description[]">{{ $section->description }}</textarea>
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
                                                <div class="form-group">
                                                    <label for="type">Label</label>
                                                    <input class="form-control" type="text" name="label[]"
                                                           value="{{ $field->label }}"/>
                                                </div>
                                                <div class="form-group">
                                                    <input type="checkbox"
                                                           name="required[{{ $field->id }}]" {{ $field->required == true ? "checked" : "" }}
                                                    "/>
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
