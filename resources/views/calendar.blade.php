@extends('layout')

@section('content')
    <script src="{{ asset('/js/calendar.js') }}"></script>
    @if(Auth::user()->isAdmin())
        <div class="container">
            <a href="{{ route('events') }}">List all event deadlines..</a>
        </div>
    @endif
    <div id="calendar"></div>
@endsection
