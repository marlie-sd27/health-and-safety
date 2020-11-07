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
                @foreach($sites as $site)
                    <option @if (old('site') == $site->site || $submission->site == $site->site) {{ 'selected' }} @endif>
                        {{$site->site}}</option>
                @endforeach
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
                                <select name="data[{{ trim($f->name) }}]"
                                        class="form-control @error($f->name) border-danger @enderror" {{ $f->required ? 'required' : '' }}>
                                    @foreach($f->options as $option)
                                        <option @if ($submission->data[trim($f->name)] == "$option") {{ 'selected' }} @endif>{{ $option }}</option>
                                    @endforeach
                                </select>
                            </label>
                            @error($f->name )
                            <p class="text-danger">{{ $errors->first($f->name) }}</p>
                            @enderror
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
                            <textarea class="form-control"
                                      name="data[{{ trim($f->name) }}]"
                                      placeholder="{{ $f->label }}"
                                    {{ $f->required ? 'required' : '' }}
                                    class="@error($f->name) border-danger @enderror"
                                    >{{ $submission->data[trim(trim(trim($f->name)))] ?? ""}}</textarea>
                            @error($f->name )
                            <p class="text-danger">{{ $errors->first($f->name) }}</p>
                            @enderror

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
                                    <input type="radio"
                                           name="data[{{ trim(trim(trim($f->name))) }}]"
                                           value="{{ $option }}" {{ isset($submission->data[trim($f->name)]) && trim($submission->data[trim($f->name)]) === trim($option) ? "checked" : ""}} {{ $f->required ? 'required' : '' }}
                                            class="@error($f->name) border-danger @enderror"
                                    />
                                    {{ $option }}
                                </label>
                            </div>
                        @endforeach
                        @error($f->name )
                        <p class="text-danger">{{ $errors->first($f->name) }}</p>
                        @enderror
                        <hr/>
                        @break

                        @case("checkbox")
                        <div class="form-group">
                            {{ $f->label }}
                            @if($f->help)
                                <button type="button"
                                        class="help @error($f->name) border-danger @enderror"
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
                        @error($f->name )
                        <p class="text-danger">{{ $errors->first($f->name) }}</p>
                        @enderror
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
                                                       value="{{ $submission->data[trim(trim($f->name))] ?? ""}}"
                                                       type="range"
                                                       class="@error($f->name) border-danger @enderror"
                                                       min="{{ $f->options[0] }}"
                                                       max="{{ $f->options[1] }}">{{ $f->options[1] }}
                            <p>Value: <span id="slider_value">{{ $submission->data[trim(trim($f->name))] ?? ""}}</span>
                            </p>
                            @error($f->name )
                            <p class="text-danger">{{ $errors->first($f->name) }}</p>
                            @enderror
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
                            <input type="{{ $f->type }}"
                                   name="{{ trim(trim($f->name)) }}"
                                   {{ $f->required ? 'required' : '' }}
                                   class="form-control-file @error($f->name) border-danger @enderror"/>
                            @error($f->name )
                            <p class="text-danger">{{ $errors->first($f->name) }}</p>
                            @enderror
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
                            <input type="{{ $f->type }}"
                                   name="data[{{ trim(trim($f->name)) }}]"
                                   value="{{ $submission->data[trim(trim($f->name))] ?? ""}}"
                                   {{ $f->required ? 'required' : '' }}
                                   class="form-control @error($f->name) border-danger @enderror"/>
                            @error($f->name )
                            <p class="text-danger">{{ $errors->first($f->name) }}</p>
                            @enderror
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
