@extends('layout')

@section('content')
    @if(Auth::user()->isAdmin())
        <div class="container">
            <a href="{{ route('events') }}">List all event deadlines..</a>
        </div>
    @endif
    <div id="calendar"></div>
@endsection
