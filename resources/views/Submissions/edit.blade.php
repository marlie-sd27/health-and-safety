@extends('layout')

@section('content')

    <a href="{{ route('submissions.show', ['submission' => $submission]) }}">Back</a>
    <div class="container">
        <h1>{{ $submission->form->title }}</h1>
        <p>{{ $submission->form->description }}</p>
        @if ($submission->form->recurrence != null)
            <p>To be completed {{ $submission->form->recurrence[0] }} time(s) every {{ $submission->form->recurrence[1] }} {{ $submission->form->recurrence[2] }}</p>
        @endif
        <p>To be completed by <b>{{ $submission->form->required_role }}</b></p>
        <p>{{ $submission->form->full_year }}</p>
    </div>
    <form method="post" action="{{ route('submissions.update', ['submission' => $submission]) }}">
        @csrf
        @method('PUT')

        <input type="hidden" value="{{ $submission->form->id }}" name="form_id"/>
        @foreach($submission->form->sections as $s)
            <article>
                <h2>{{ $s->title }}</h2>
                <p>{{ $s->description }}</p>
                @foreach($s->fields as $f)
                    <label for="{{ $f->name }}">{{ $f->label }}</label>
                    @switch($f->type)
                        @case("select")
                        <div class="form-group">
                            <select name="data[{{ $f->name }}]" class="form-control" {{ $f->required ? 'required' : '' }}>
                                @foreach($f->options as $option)
                                    <option @if ($submission->data[$f->label] == "$option") {{ 'selected' }} @endif>{{ $option }}</option>
                                @endforeach
                            </select>
                        </div>
                        @break

                        @case("textarea")
                        <div class="form-group">
                            <textarea class="form-control" name="data[{{ $f->name }}]" placeholder="{{ $f->name }}" {{ $f->required ? 'required' : '' }}>{{ $submission->data[$f->label] }}</textarea>
                        </div>
                        @break

                        @case("radio")
                        @foreach($f->options as $option)
                            <div class="form-group">
                                <input type="radio" name="data[{{ $f->name }}]" value="{{ $option }}" {{ trim($submission->data[$f->label]) === trim($option) ? "checked" : ""}} {{ $f->required ? 'required' : '' }}/>{{ $option }}
                            </div>
                        @endforeach
                        <hr/>
                        @break

                        @case("checkbox")
                        @foreach($f->options as $option)
                            <div class="form-group">
                                <input type="checkbox" name="data[{{ $f->name }}][{{ $option }}]" {{ in_array($option, explode(", ", $submission->data[$f->label])) ? "checked" : "" }} {{ $f->required ? 'required' : '' }} />{{ $option }}
                            </div>
                        @endforeach
                        <hr/>
                        @break

                        @case("slider")
                        <div class="form-group">
                            {{ $f->options[0] }}<input id="slider" name="data[{{$f->name}}]" value="{{ $submission->data[$f->label] }}" type="range" min="{{ $f->options[0] }}" max="{{ $f->options[1] }}" >{{ $f->options[1] }}
                            <p>Value: <span id="slider_value">{{ $submission->data[$f->label] }}</span></p>
                        </div>
                        @break

                        @default
                        <input type="{{ $f->type }}" name="data[{{ $f->name }}]" value="{{ $submission->data[$f->label] }}" {{ $f->required ? 'required' : '' }} class="form-control"/>
                    @endswitch
                @endforeach
            </article>
        @endforeach

        <hr>

        <div class="container align-content-center">
            <button class="btn btn-block btn-lg btn-success" type="submit">Submit</button>
            <button class="btn btn-block btn-lg btn-secondary" type="reset">Reset to Original Values</button>
        </div>
    </form>
@endsection
