@extends('layout')

@section('content')
    <a href="{{ route('forms.index') }}">Back to Index</a>
    <div class="container">
        <h1>{{ $form->title }}</h1>
        <p>{{ $form->description }}</p>
        <p>To be completed {{ $form->recurrence[0] }} time(s) every {{ $form->recurrence[1] }} {{ $form->recurrence[2] }}</p>
        <p>To be completed by <b>{{ $form->required_role }}</b></p>
        <p>{{ $form->full_year }}</p>
    </div>
    <div class="container">
        @foreach($form['sections'] as $s)
            <article>
                <h2>{{ $s->title }}</h2>
                <p>{{ $s->description }}</p>
                @foreach($s['fields'] as $f)
                    <div class="form-group">
                        <label for="{{ $f->name }}">{{ $f->label }}</label>
                        @switch($f->type)
                            @case("select")
                            <div class="form-group">
                                <select name="{{ $f->name }}" {{ $f->required ? 'required' : '' }}>
                                    @foreach($f->options as $option)
                                        <option>{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @break

                            @case("textarea")
                            <div class="form-group">
                                <textarea class="form-control" name="{{ $f->name }}" placeholder="{{ $f->name }}" {{ $f->required ? 'required' : '' }}></textarea>
                            </div>
                            @break

                            @case("radio")
                            @foreach($f->options as $option)
                                <div class="form-group">
                                    <input type="radio" name="{{ $f->name }}" {{ $f->required ? 'required' : '' }}/>{{ $option }}
                                </div>
                            @endforeach
                            @break

                            @case("checkbox")
                            @foreach($f->options as $option)
                                <div class="form-group">
                                    <input type="checkbox" name="{{ $f->name }}[]" {{ $f->required ? 'required' : '' }}/>{{ $option }}
                                </div>
                            @endforeach
                            @break

                            @case("slider")
                            <div class="form-group">
                                {{ $f->options[0] }}<input type="range" min="{{ $f->options[0] }}" max="{{ $f->options[1] }}">{{ $f->options[1] }}
                                <p>value: <span class="slider_value"></span></p>
                            </div>
                            @break

                            @default
                            <input type="{{ $f->type }}" name="{{ $f->name }}" {{ $f->required ? 'required' : '' }} class="form-control"/>
                        @endswitch
                    </div>
                @endforeach
            </article>
        @endforeach
    </div>
@endsection
