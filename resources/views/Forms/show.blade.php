@extends('layout')

@section('content')
    <a href="{{ route('forms.index') }}">Back</a>
    <div class="container">
        <h1>{{ $form->title }}</h1>
        <p>{{ $form->description }}</p>
        <p>{{ $form->recurrence }}</p>
        <p>{{ $form->required_role }}</p>
        <p>{{ $form->full_year }}</p>
    </div>
    <div class="container">
        @foreach($form['sections'] as $s)
            <h2>{{ $s->title }}</h2>
            <p>{{ $s->description }}</p>
            @foreach($s['fields'] as $f)
                <h3>Label</h3>
                <p>{{ $f->label }}</p>
                <input type="{{ $f->type }}" name="{{ $f->name }}" required="{{ $f->required }}"/>
            @endforeach

        @endforeach
    </div>
@endsection
