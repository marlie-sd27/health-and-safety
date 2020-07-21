@extends('layout')

@section('content')

    <a href="{{ route('submissions.show', ['submission' => $submission]) }}">Back</a>
    <div class="container">
        <h1>{{ $submission->form->title }}</h1>
        @if ($submission->form->interval != null)
            <p><small>To be completed every {{ $submission->form->interval }} by <b>{{ $submission->form->required_for }}</b></small></p>
        @endif
        <p style="white-space: pre-wrap;">{{ $submission->form->description }}</p>
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
                    @switch($f->type)
                        @case("select")
                        <div class="form-group">
                            <label>{{ $f->label }}
                                <select name="data[{{ $f->name }}]" class="form-control" {{ $f->required ? 'required' : '' }}>
                                    @foreach($f->options as $option)
                                        <option @if ($submission->data[$f->label] == "$option") {{ 'selected' }} @endif>{{ $option }}</option>
                                    @endforeach
                                </select>
                            </label>
                        </div>
                        @break

                        @case("textarea")
                        <div class="form-group">
                            <label>{{ $f->label }}</label>
                                <textarea class="form-control" name="data[{{ $f->name }}]" placeholder="{{ $f->name }}" {{ $f->required ? 'required' : '' }}>{{ $submission->data[$f->label] ?? ""}}</textarea>

                        </div>
                        @break

                        @case("radio")
                        {{ $f->label }}
                        @foreach($f->options as $option)
                            <div>
                                <label>
                                    <input type="radio" name="data[{{ $f->name }}]" value="{{ $option }}" {{ isset($submission->data[$f->label]) && trim($submission->data[$f->label]) === trim($option) ? "checked" : ""}} {{ $f->required ? 'required' : '' }}/>
                                    {{ $option }}
                                </label>
                            </div>
                        @endforeach
                        <hr/>
                        @break

                        @case("checkbox")
                        {{ $f->label }}
                        @foreach($f->options as $option)
                            <div>
                                <label>
                                    <input type="checkbox" name="data[{{ $f->name }}][{{ $option }}]" {{ in_array($option, explode(", ", $submission->data[$f->label])) ? "checked" : "" }} {{ $f->required ? 'required' : '' }} />
                                    {{ $option }}
                                </label>
                            </div>
                        @endforeach
                        <hr/>
                        @break

                        @case("slider")
                        <div class="form-group">
                            <label for="slider">{{ $f->label }}</label>
                            {{ $f->options[0] }}<input id="slider" name="data[{{$f->name}}]" value="{{ $submission->data[$f->label] ?? ""}}" type="range" min="{{ $f->options[0] }}" max="{{ $f->options[1] }}" >{{ $f->options[1] }}
                            <p>Value: <span id="slider_value">{{ $submission->data[$f->label] ?? ""}}</span></p>
                        </div>
                        @break

                        @default
                        <div class="form-group">
                            <label>{{ $f->label }}</label>
                                <input type="{{ $f->type }}" name="data[{{ $f->name }}]"
                                       value="{{ $submission->data[$f->label] ?? ""}}"
                                       {{ $f->required ? 'required' : '' }} class="form-control"/>
                        </div>
                    @endswitch
                @endforeach
            </article>
        @endforeach

        <hr>

        <div class="container align-content-center">
            <button class="btn btn-block btn-lg btn-success" type="submit">Save</button>
            <button class="btn btn-block btn-lg btn-secondary" type="reset">Reset to Original Values</button>
        </div>
    </form>
@endsection
