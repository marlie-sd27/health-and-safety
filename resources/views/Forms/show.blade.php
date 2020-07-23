@extends('layout')

@section('content')

    @if(Auth::user()->isAdmin())
        <a href="{{ url()->previous() }}">Back</a>
        <a class="float-right" href="{{ route('forms.edit', ['form' => $form->id]) }}">Edit</a>
    @endif
    <div class="container">
        <h1>{{ $form->title }}</h1>
        @if ($form->interval != null)
            <p><small>To be completed every {{ $form->interval }} by <b>{{ $form->required_for }}</b></small></p>
        @endif
        <p style="white-space: pre-wrap;">{{ $form->description }}</p>
    </div>
    <form method="post" action="{{ route('submissions.store') }}">
        @csrf
        <input type="hidden" value="{{ $form->id }}" name="form_id"/>
        @foreach($form->sections as $s)
            <article>
                <h2>{{ $s->title }}</h2>
                <p>{{ $s->description }}</p>
                @foreach($s->fields as $f)
                    @switch($f->type)
                        @case("select")
                        <div class="form-group">
                            <label>{{ $f->label }}
                                <select name="data[{{ $f->name }}]"
                                        class="form-control" {{ $f->required ? 'required' : '' }}>
                                    @foreach($f->options as $option)
                                        <option>{{ $option }}</option>
                                    @endforeach
                                </select>
                            </label>
                        </div>
                        @break

                        @case("textarea")
                        <div class="form-group">
                            <label>{{ $f->label }}</label>
                                <textarea class="form-control" name="data[{{ $f->name }}]" {{ $f->required ? 'required' : '' }}></textarea>
                        </div>
                        @break

                        @case("radio")
                        {{ $f->label }}
                        @foreach($f->options as $option)
                            <div>
                                <label>
                                    <input type="radio" value="{{ $option }}"
                                           name="data[{{ $f->name }}]" {{ $f->required ? 'required' : '' }}/>
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
                                    <input type="checkbox" name="data[{{ $f->name }}][{{ $option }}]"/>
                                    {{ $option }}
                                </label>
                            </div>
                        @endforeach
                        <hr/>
                        @break

                        @case("slider")
                        <div class="form-group">
                            <label for="slider">{{ $f->label }}</label>
                            {{ $f->options[0] }}<input type="range" id="slider" name="data[{{$f->name}}]"
                                                       min="{{ $f->options[0] }}"
                                                       max="{{ $f->options[1] }}">{{ $f->options[1] }}
                            <p>Value: <span id="slider_value"></span></p>
                        </div>
                        @break

                        @default
                        <div class="form-group">
                            <label>{{ $f->label }}</label>
                                <input type="{{ $f->type }}" name="data[{{ $f->name }}]"
                                       {{ $f->required ? 'required' : '' }} class="form-control"/>

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
