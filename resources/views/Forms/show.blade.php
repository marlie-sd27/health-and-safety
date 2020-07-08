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
                                <select name="{{ $f->name }}" class="form-control" {{ $f->required ? 'required' : '' }}>
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
                                {{ $f->options[0] }}<input type="range" min="{{ $f->options[0] }}" max="{{ $f->options[1] }}" >{{ $f->options[1] }}
                                <p>value: <span class="slider_value"></span></p>
                            </div>
                            @break

                            @default
                            <input type="{{ $f->type }}" name="{{ $f->name }}" {{ $f->required ? 'required' : '' }} class="form-control"/>
                        @endswitch
                @endforeach
            </article>
        @endforeach

        <button class="btn btn-primary" type="submit">Submit</button>
        <button class="btn btn-secondary" type="reset">Reset</button>
    </form>
@endsection
