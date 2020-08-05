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
        <article>
            <label>School/Site</label>
            <select name="site" class="form-control">
                <option @if ($submission->site == "") {{ 'selected' }} @endif>--</option>
                <option @if ($submission->site == "100 Mile Elementary") {{ 'selected' }} @endif>100 Mile Elementary</option>
                <option @if ($submission->site == "100 Mile Maintenance") {{ 'selected' }} @endif>100 Mile Maintenance</option>
                <option @if ($submission->site == "150 Mile Elementary") {{ 'selected' }} @endif>150 Mile Elementary</option>
                <option @if ($submission->site == "Alexis Creek") {{ 'selected' }} @endif>Alexis Creek</option>
                <option @if ($submission->site == "Anahim") {{ 'selected' }} @endif>Anahim</option>
                <option @if ($submission->site == "Big Lake") {{ 'selected' }} @endif>Big Lake</option>
                <option @if ($submission->site == "Board Office") {{ 'selected' }} @endif>Board Office</option>
                <option @if ($submission->site == "Cataline") {{ 'selected' }} @endif>Cataline</option>
                <option @if ($submission->site == "Chilcotin Road") {{ 'selected' }} @endif>Chilcotin Road</option>
                <option @if ($submission->site == "Dog Creek") {{ 'selected' }} @endif>Dog Creek</option>
                <option @if ($submission->site == "Forest Grove") {{ 'selected' }} @endif>Forest Grove</option>
                <option @if ($submission->site == "Horse Lake") {{ 'selected' }} @endif>Horse Lake</option>
                <option @if ($submission->site == "Horsefly") {{ 'selected' }} @endif>Horsefly</option>
                <option @if ($submission->site == "GROW WL") {{ 'selected' }} @endif>GROW WL</option>
                <option @if ($submission->site == "LCS-Williams Lake") {{ 'selected' }} @endif>LCS-Williams Lake</option>
                <option @if ($submission->site == "LCS-Columneetza") {{ 'selected' }} @endif>LCS-Columneetza</option>
                <option @if ($submission->site == "Likely") {{ 'selected' }} @endif>Likely</option>
                <option @if ($submission->site == "Marie Sharpe") {{ 'selected' }} @endif>Marie Sharpe</option>
                <option @if ($submission->site == "Mile 108 Elementary") {{ 'selected' }} @endif>Mile 108 Elementary</option>
                <option @if ($submission->site == "Mountview") {{ 'selected' }} @endif>Mountview</option>
                <option @if ($submission->site == "Maintenance Yard") {{ 'selected' }} @endif>Maintenance Yard</option>
                <option @if ($submission->site == "Naughtaneqed") {{ 'selected' }} @endif>Naughtaneqed</option>
                <option @if ($submission->site == "Nenqayni") {{ 'selected' }} @endif>Nenqayni</option>
                <option @if ($submission->site == "Nesika") {{ 'selected' }} @endif>Nesika</option>
                <option @if ($submission->site == "PSO") {{ 'selected' }} @endif>PSO</option>
                <option @if ($submission->site == "Support Services") {{ 'selected' }} @endif>Support Services</option>
                <option @if ($submission->site == "Tatla Lake") {{ 'selected' }} @endif>Tatla Lake</option>
            </select>
        </article>

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
                                    <input type="checkbox" name="data[{{ $f->name }}][{{ $option }}]" {{ isset($submission->data[$f->label]) && in_array($option, explode(", ", $submission->data[$f->label])) ? "checked" : "" }} {{ $f->required ? 'required' : '' }} />
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
