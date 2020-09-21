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
                <select name="site" class="form-control @error('site') border-danger @enderror">
                    <option @if (old('site') == '--' || $submission->site == "") {{ 'selected' }} @endif>--</option>
                    <option @if ( old('site') == '100 Mile Elementary' || $submission->site == "100 Mile Elementary") {{ 'selected' }} @endif>100 Mile Elementary
                    </option>
                    <option @if (old('site') == '100 Mile Maintenance' || $submission->site == "100 Mile Maintenance") {{ 'selected' }} @endif>100 Mile
                        Maintenance
                    </option>
                    <option @if (old('site') == '150 Mile Elementary' || $submission->site == "150 Mile Elementary") {{ 'selected' }} @endif>150 Mile Elementary
                    </option>
                    <option @if (old('site') == 'Alexis Creek' || $submission->site == "Alexis Creek") {{ 'selected' }} @endif>Alexis Creek</option>
                    <option @if (old('site') == 'Anahim' || $submission->site == "Anahim") {{ 'selected' }} @endif>Anahim</option>
                    <option @if (old('site') == 'Big Lake' || $submission->site == "Big Lake") {{ 'selected' }} @endif>Big Lake</option>
                    <option @if (old('site') == 'Board Office' || $submission->site == "Board Office") {{ 'selected' }} @endif>Board Office</option>
                    <option @if (old('site') == 'Cataline' || $submission->site == "Cataline") {{ 'selected' }} @endif>Cataline</option>
                    <option @if (old('site') == 'Chilcotin Road' || $submission->site == "Chilcotin Road") {{ 'selected' }} @endif>Chilcotin Road</option>
                    <option @if (old('site') == 'Dog Creek' || $submission->site == "Dog Creek") {{ 'selected' }} @endif>Dog Creek</option>
                    <option @if (old('site') == 'Forest Grove' || $submission->site == "Forest Grove") {{ 'selected' }} @endif>Forest Grove</option>
                    <option @if (old('site') == 'Horse Lake' || $submission->site == "Horse Lake") {{ 'selected' }} @endif>Horse Lake</option>
                    <option @if (old('site') == 'Horsefly' || $submission->site == "Horsefly") {{ 'selected' }} @endif>Horsefly</option>
                    <option @if (old('site') == 'GROW WL' || $submission->site == "GROW WL") {{ 'selected' }} @endif>GROW WL</option>
                    <option @if (old('site') == 'Lac La Hache' || $submission->site == "Lac La Hache") {{ 'selected' }} @endif>Lac La Hache</option>
                    <option @if (old('site') == 'LCS-Williams Lake' || $submission->site == "LCS-Williams Lake") {{ 'selected' }} @endif>LCS-Williams Lake
                    </option>
                    <option @if (old('site') == 'LCS-Columneetza' || $submission->site == "LCS-Columneetza") {{ 'selected' }} @endif>LCS-Columneetza
                    </option>
                    <option @if (old('site') == 'Likely' || $submission->site == "Likely") {{ 'selected' }} @endif>Likely</option>
                    <option @if (old('site') == 'Marie Sharpe' || $submission->site == "Marie Sharpe") {{ 'selected' }} @endif>Marie Sharpe</option>
                    <option @if (old('site') == 'Mile 108 Elementary' || $submission->site == "Mile 108 Elementary") {{ 'selected' }} @endif>Mile 108 Elementary
                    </option>
                    <option @if (old('site') == 'Mountview' || $submission->site == "Mountview") {{ 'selected' }} @endif>Mountview</option>
                    <option @if (old('site') == 'Maintenance Yard' || $submission->site == "Maintenance Yard") {{ 'selected' }} @endif>Maintenance Yard
                    </option>
                    <option @if (old('site') == 'Naughtaneqed' || $submission->site == "Naughtaneqed") {{ 'selected' }} @endif>Naughtaneqed</option>
                    <option @if (old('site') == 'Nenqayni' || $submission->site == "Nenqayni") {{ 'selected' }} @endif>Nenqayni</option>
                    <option @if (old('site') == 'Nesika' || $submission->site == "Nesika") {{ 'selected' }} @endif>Nesika</option>
                    <option @if (old('site') == 'PSO' || $submission->site == "PSO") {{ 'selected' }} @endif>PSO</option>
                    <option @if (old('site') == 'Support Services' || $submission->site == "Support Services") {{ 'selected' }} @endif>Support Services
                    </option>
                    <option @if (old('site') == 'Tatla Lake' || $submission->site == "Tatla Lake") {{ 'selected' }} @endif>Tatla Lake</option>
                </select>
            <div class="form-group">
                @error("site")
                <p class="text-danger">{{ $errors->first("site") }}</p>
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
                                <select name="data[{{ trim(trim(trim($f->name))) }}]"
                                        class="form-control" {{ $f->required ? 'required' : '' }}>
                                    @foreach($f->options as $option)
                                        <option @if ($submission->data[trim(trim(trim($f->name)))] == "$option") {{ 'selected' }} @endif>{{ $option }}</option>
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
                            <textarea class="form-control" name="data[{{ trim(trim(trim($f->name))) }}]"
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
