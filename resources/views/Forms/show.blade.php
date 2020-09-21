@extends('layout')

@section('content')

    <script type="module" src="/js/autolinker.js"></script>

    @if(Auth::user()->isAdmin())
        <a href="{{ url()->previous() }}">Back</a>
        <a class="float-right" href="{{ route('forms.edit', ['form' => $form->id]) }}">Edit</a>
    @endif
    <div class="container">
        <h1>{{ $form->title }}</h1>
        @if(isset($event))
            <h3>Due: {{ App\Helpers\Helper::makeDateReadable($event->date) }}</h3>
        @endif
        @if ($form->interval != null)
            <p><small>To be completed every {{ $form->interval }} by <b>{{ $form->required_for }}</b></small></p>
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
            <select name="site" class="form-control @error('site') border-danger @enderror">
                <option @if(old('site') == '--') {{ 'selected' }} @endif>--</option>
                <option @if(old('site') == '100 Mile Elementary') {{ 'selected' }} @endif>100 Mile Elementary</option>
                <option @if(old('site') == '100 Mile Maintenance') {{ 'selected' }} @endif>100 Mile Maintenance</option>
                <option @if(old('site') == '150 Mile Elementary') {{ 'selected' }} @endif>150 Mile Elementary</option>
                <option @if(old('site') == 'Alexis Creek') {{ 'selected' }} @endif>Alexis Creek</option>
                <option @if(old('site') == 'Anahim') {{ 'selected' }} @endif>Anahim</option>
                <option @if(old('site') == 'Big Lake') {{ 'selected' }} @endif>Big Lake</option>
                <option @if(old('site') == 'Board Office') {{ 'selected' }} @endif>Board Office</option>
                <option @if(old('site') == 'Cataline') {{ 'selected' }} @endif>Cataline</option>
                <option @if(old('site') == 'Chilcotin Road') {{ 'selected' }} @endif>Chilcotin Road</option>
                <option @if(old('site') == 'Dog Creek') {{ 'selected' }} @endif>Dog Creek</option>
                <option @if(old('site') == 'Forest Grove') {{ 'selected' }} @endif>Forest Grove</option>
                <option @if(old('site') == 'Horse Lake') {{ 'selected' }} @endif>Horse Lake</option>
                <option @if(old('site') == 'Horsefly') {{ 'selected' }} @endif>Horsefly</option>
                <option @if(old('site') == 'GROW WL') {{ 'selected' }} @endif>GROW WL</option>
                <option @if(old('site') == 'Lac La Hache') {{ 'selected' }} @endif>Lac La Hache</option>
                <option @if(old('site') == 'LCS-Williams Lake') {{ 'selected' }} @endif>LCS-Williams Lake</option>
                <option @if(old('site') == 'LCS-Columneetza') {{ 'selected' }} @endif>LCS-Columneetza</option>
                <option @if(old('site') == 'Likely') {{ 'selected' }} @endif>Likely</option>
                <option @if(old('site') == 'Marie Sharpe') {{ 'selected' }} @endif>Marie Sharpe</option>
                <option @if(old('site') == 'Mile 108 Elementary') {{ 'selected' }} @endif>Mile 108 Elementary</option>
                <option @if(old('site') == 'Mountview') {{ 'selected' }} @endif>Mountview</option>
                <option @if(old('site') == 'Maintenance Yard') {{ 'selected' }} @endif>Maintenance Yard</option>
                <option @if(old('site') == 'Naughtaneqed') {{ 'selected' }} @endif>Naughtaneqed</option>
                <option @if(old('site') == 'Nenqayni') {{ 'selected' }} @endif>Nenqayni</option>
                <option @if(old('site') == 'Nesika') {{ 'selected' }} @endif>Nesika</option>
                <option @if(old('site') == 'PSO') {{ 'selected' }} @endif>PSO</option>
                <option @if(old('site') == 'Support Services') {{ 'selected' }} @endif>Support Services</option>
                <option @if(old('site') == 'Tatla Lake') {{ 'selected' }} @endif>Tatla Lake</option>
            </select>
            <div class="form-group">
                @error("site")
                <p class="text-danger">{{ $errors->first("site") }}</p>
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
                                    class="form-control" {{ $f->required ? 'required' : '' }}>
                                @foreach($f->options as $option)
                                    <option>{{ $option }}</option>
                                @endforeach
                            </select>
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
                                      name="data[{{ trim($f->name) }}]" {{ $f->required ? 'required' : '' }}></textarea>
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
                                           name="data[{{ trim($f->name) }}]" {{ $f->required ? 'required' : '' }}/>
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
                                    <input type="checkbox" name="data[{{ trim($f->name) }}][{{ $option }}]"/>
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
                            {{ $f->options[0] }}<input type="range" id="slider" name="data[{{trim($f->name)}}]"
                                                       min="{{ $f->options[0] }}"
                                                       max="{{ $f->options[1] }}">{{ $f->options[1] }}
                            <p>Value: <span id="slider_value"></span></p>
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
                            <input type="{{ $f->type }}" name="{{ trim($f->name) }}"
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
                            <input type="{{ $f->type }}" name="data[{{ trim($f->name) }}]"
                                   {{ $f->required ? 'required' : '' }} class="form-control"/>

                        </div>
                    @endswitch
                @endforeach
            </article>
        @endforeach

        <hr>

        @if(!Auth::user()->isAdmin())
            <div class="container align-content-center">
                <button class="btn btn-block btn-lg btn-success" type="submit">Submit</button>
                <button class="btn btn-block btn-lg btn-secondary" type="reset">Reset</button>
            </div>
        @endif
    </form>
@endsection
