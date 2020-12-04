@extends('layout')

@section('content')

    <script type="module" src="/js/autolinker.js"></script>

    <a href="{{ route('submissions.show', ['submission' => $submission]) }}">Back</a>
    <div class="container">
        <h1>{{ $submission->form->title }}</h1>
        @if ($submission->form->interval != null)
            <p><small>To be completed every {{ $submission->form->interval }} by
                    <b>{{ $submission->form->required_for }}</b></small></p>
        @endif
        <p style="white-space: pre-wrap;">{{ $submission->form->description }}</p>
    </div>
    <form method="post" action="{{ route('submissions.update', ['submission' => $submission]) }}"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <input type="hidden" value="{{ $submission->form->id }}" name="form_id"/>
        <article class="container">
                <label><span class="required">*</span>School/Site</label>
                <select name="sites_id" class="form-control @error('sites_id') border-danger @enderror">
                    <option @if (old('sites_id') == '' || $submission->sites_id == '') {{ 'selected' }} @endif></option>
                    @foreach($sites as $site)
                        <option value="{{ $site->id }}" @if (old('sites_id') == $site->id || $submission->sites_id == $site->id) {{ 'selected' }} @endif>
                            {{$site->site}}</option>
                    @endforeach
                </select>
            <div class="form-group">
                @error("sites_id")
                <p class="text-danger">{{ $errors->first("sites_id") }}</p>
                @enderror
            </div>
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
                                @if($f->help)
                                    <button type="button"
                                            class="help"
                                            data-container="body"
                                            data-toggle="popover"
                                            data-placement="right"
                                            data-content="{{ $f->help }}">
                                        <b>?</b>
                                    </button>
                                @endif
                                <select name="data[{{ trim($f->name) }}]"
                                        class="form-control" {{ $f->required ? 'required' : '' }}>
                                    @foreach($f->options as $option)
                                        <option @if ($submission->data[trim($f->name)] == "$option") {{ 'selected' }} @endif>{{ $option }}</option>
                                    @endforeach
                                </select>
                            </label>
                        </div>
                        @break

                        @case("textarea")
                        <div class="form-group">
                            <label>{{ $f->label }}</label>
                            @if($f->help)
                                <button type="button"
                                        class="help"
                                        data-container="body"
                                        data-toggle="popover"
                                        data-placement="right"
                                        data-content="{{ $f->help }}">
                                    <b>?</b>
                                </button>
                            @endif
                            <textarea class="form-control" name="data[{{ trim($f->name) }}]"
                                      placeholder="{{ $f->label }}" {{ $f->required ? 'required' : '' }}>{{ $submission->data[trim(trim(trim($f->name)))] ?? ""}}</textarea>

                        </div>
                        @break

                        @case("radio")
                        <div class="form-group">
                            {{ $f->label }}
                            @if($f->help)
                                <button type="button"
                                        class="help"
                                        data-container="body"
                                        data-toggle="popover"
                                        data-placement="right"
                                        data-content="{{ $f->help }}">
                                    <b>?</b>
                                </button>
                            @endif
                        </div>
                        @foreach($f->options as $option)
                            <div>
                                <label>
                                    <input type="radio" name="data[{{ trim(trim(trim($f->name))) }}]"
                                           value="{{ $option }}" {{ isset($submission->data[trim(trim(trim($f->name)))]) && trim($submission->data[trim(trim($f->name))]) === trim($option) ? "checked" : ""}} {{ $f->required ? 'required' : '' }}/>
                                    {{ $option }}
                                </label>
                            </div>
                        @endforeach
                        <hr/>
                        @break

                        @case("checkbox")
                        <div class="form-group">
                            {{ $f->label }}
                            @if($f->help)
                                <button type="button"
                                        class="help"
                                        data-container="body"
                                        data-toggle="popover"
                                        data-placement="right"
                                        data-content="{{ $f->help }}">
                                    <b>?</b>
                                </button>
                            @endif
                        </div>
                        @foreach($f->options as $option)
                            <div>
                                <label>
                                    <input type="checkbox"
                                           name="data[{{ trim(trim($f->name)) }}][{{ $option }}]" {{ isset($submission->data[trim(trim($f->name))]) && in_array($option, explode(", ", $submission->data[trim(trim($f->name))])) ? "checked" : "" }} {{ $f->required ? 'required' : '' }} />
                                    {{ $option }}
                                </label>
                            </div>
                        @endforeach
                        <hr/>
                        @break

                        @case("slider")
                        <div class="form-group">
                            <label for="slider">{{ $f->label }}</label>
                            @if($f->help)
                                <button type="button"
                                        class="help"
                                        data-container="body"
                                        data-toggle="popover"
                                        data-placement="right"
                                        data-content="{{ $f->help }}">
                                    <b>?</b>
                                </button>
                            @endif
                            <br>
                            {{ $f->options[0] }}<input id="slider" name="data[{{trim(trim($f->name))}}]"
                                                       value="{{ $submission->data[trim(trim($f->name))] ?? ""}}" type="range"
                                                       min="{{ $f->options[0] }}"
                                                       max="{{ $f->options[1] }}">{{ $f->options[1] }}
                            <p>Value: <span id="slider_value">{{ $submission->data[trim(trim($f->name))] ?? ""}}</span></p>
                        </div>
                        @break

                        @case("file")
                        <div class="form-group">
                            <label>{{ $f->label }}</label>
                            @if($f->help)
                                <button type="button"
                                        class="help"
                                        data-container="body"
                                        data-toggle="popover"
                                        data-placement="right"
                                        data-content="{{ $f->help }}">
                                    <b>?</b>
                                </button>
                            @endif
                            <input type="{{ $f->type }}" name="{{ trim(trim($f->name)) }}"
                                   {{ $f->required ? 'required' : '' }} class="form-control-file"/>
                        </div>
                        @break

                        @default
                        <div class="form-group">
                            <label>{{ $f->label }}</label>
                            @if($f->help)
                                <button type="button"
                                        class="help"
                                        data-container="body"
                                        data-toggle="popover"
                                        data-placement="right"
                                        data-content="{{ $f->help }}">
                                    <b>?</b>
                                </button>
                            @endif
                            <input type="{{ $f->type }}" name="data[{{ trim(trim($f->name)) }}]"
                                   value="{{ $submission->data[trim(trim($f->name))] ?? ""}}"
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
