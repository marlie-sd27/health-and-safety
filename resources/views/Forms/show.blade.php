@extends('layout')

@section('content')

    <script type="module" src="/js/autolinker.js"></script>

        <a href="{{ url()->previous() }}">Back</a>
    @if($admin)
        <a class="float-right" href="{{ route('forms.edit', ['form' => $form->id]) }}"><i class="fa fa-pencil-alt"></i> Edit</a>
    @endif
    <div class="container">
        <h1>{{ $form->title }}</h1>
        @if(isset($event))
            <h3>Due: {{ App\Helpers\Helper::makeDateReadable($event->date) }}</h3>
        @endif
        @if ($form->interval != null)
            <p><small>To be completed every {{ $form->interval }} </small></p>
        @endif
        <p style="white-space: pre-wrap;" class="autolink">{{ $form->description }}</p>
    </div>
    <form method="post" action="{{ route('submissions.store') }}" enctype="multipart/form-data">
        @csrf
        <article class="container">
            <input type="hidden" value="{{ $form->id }}" name="form_id"/>
            @if(isset($event))
                <input type="hidden" value="{{ $event->id }}" name="event_id"/>
            @endif
            <span class="required">*</span><label>School/Site</label>
            <select name="sites_id" class="form-control @error('sites_id') border-danger @enderror">
                <option @if(old('sites_id') == '') {{ 'selected' }} @endif></option>
                @foreach($sites as $site)
                    <option value="{{ $site->id }}" @if(old('sites_id') == $site->id) {{ 'selected' }} @endif>{{ $site->site}}</option>
                @endforeach
            </select>
            <div class="form-group">
                @error("sites_id")
                <p class="text-danger">{{ $errors->first("sites_id") }}</p>
                @enderror
            </div>
        </article>
        @foreach($form->sections as $s)
            <article>
                <h2>{{ $s->title }}</h2>
                <p style="white-space: pre-wrap;" class="autolink">{{ $s->description }}</p>
                @foreach($s->fields as $f)
                    @switch($f->type)
                        @case("select")
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
                            <select name="data[{{ trim($f->name) }}]"
                                    class="form-control @error($f->name) border-danger @enderror" {{ $f->required ? 'required' : '' }}>
                                @foreach($f->options as $option)
                                    <option>{{ $option }}</option>
                                @endforeach
                            </select>
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
                            <textarea class="form-control @error($f->name) border-danger @enderror"
                                      name="data[{{ trim($f->name) }}]" {{ $f->required ? 'required' : '' }}></textarea>
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
                                    <input type="radio" value="{{ $option }}"
                                           name="data[{{ trim($f->name) }}]" {{ $f->required ? 'required' : '' }}
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
                                    <input type="checkbox" name="data[{{ trim($f->name) }}][{{ $option }}]"/>
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
                            {{ $f->options[0] }}<input type="range" id="slider" name="data[{{trim($f->name)}}]"
                                                       min="{{ $f->options[0] }}"
                                                       max="{{ $f->options[1] }}">{{ $f->options[1] }}
                            <p>Value: <span id="slider_value"></span></p>
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
                                   name="{{ trim($f->name) }}"
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
                            <input type="{{ $f->type }}" name="data[{{ trim($f->name) }}]"
                                   {{ $f->required ? 'required' : '' }} class="form-control"/>

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
            <button class="btn btn-block btn-lg btn-success" type="submit">Submit</button>
            <button class="btn btn-block btn-lg btn-secondary" type="reset">Reset</button>
        </div>
    </form>
@endsection
