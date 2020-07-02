@extends('layout')

@section('content')
    <a href="{{ route('forms.index') }}">Back</a>
    <div class="container">
        <p>{{ $form->title }}</p>
        <p>{{ $form->description }}</p>
        <p>{{ $form->recurrence }}</p>
        <p>{{ $form->required_role }}</p>
        <p>{{ $form->full_year }}</p>
    </div>
@endsection
