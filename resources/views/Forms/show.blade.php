@extends('layout')

@section('content')
    <a href="{{ route('forms.index') }}">Back to Index</a>
    <a class="float-right" href="{{ route('forms.edit', ['form' => $form->id]) }}">Edit</a>
    <div class="container">
        <h1>{{ $form->title }}</h1>
        <p>{{ $form->description }}</p>
        @if ($form->recurrence != null)
            <p>To be completed {{ $form->recurrence[0] }} time(s) every {{ $form->recurrence[1] }} {{ $form->recurrence[2] }}</p>
        @endif
        <p>To be completed by <b>{{ $form->required_role }}</b></p>
        <p>{{ $form->full_year }}</p>
    </div>
    <form method="post" action="{{ route('submissions.store') }}">
        @csrf

        <input type="hidden" value="{{ $form->id }}" name="form_id"/>
        @foreach($form->sections as $s)
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
                                        <option>{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @break

                            @case("textarea")
                            <div class="form-group">
                                <textarea class="form-control" name="data[{{ $f->name }}]" {{ $f->required ? 'required' : '' }}></textarea>
                            </div>
                            @break

                            @case("radio")
                            @foreach($f->options as $option)
                                <div class="form-group">
                                    <input type="radio" value="{{ $option }}" name="data[{{ $f->name }}]" {{ $f->required ? 'required' : '' }}/>{{ $option }}
                                </div>
                            @endforeach
                            <hr/>
                            @break

                            @case("checkbox")
                            @foreach($f->options as $option)
                                <div class="form-group">
                                    <input type="checkbox" name="data[{{ $f->name }}][]"/>{{ $option }}
                                </div>
                            @endforeach
                            <hr/>
                            @break

                            @case("slider")
                            <div class="form-group">
                                {{ $f->options[0] }}<input type="range" id="slider" name="data[{{$f->name}}]" min="{{ $f->options[0] }}" max="{{ $f->options[1] }}" >{{ $f->options[1] }}
                                <p>Value: <span id="slider_value"></span></p>
                            </div>
                            @break

                            @default
                            <input type="{{ $f->type }}" name="data[{{ $f->name }}]" {{ $f->required ? 'required' : '' }} class="form-control"/>
                        @endswitch
                @endforeach
            </article>
        @endforeach

        <hr>

        <div class="container" align="center">
            <button class="btn btn-block btn-lg btn-success" type="submit">Submit</button>
            <button class="btn btn-block btn-lg btn-secondary" type="reset">Reset</button>
        </div>
    </form>
@endsection
