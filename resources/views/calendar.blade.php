@extends('layout')

@section('content')
    <script src="{{ asset('/js/calendar.js') }}"></script>
    @if($admin)
        <div class="container">
            <a href="{{ route('events') }}">List all event deadlines..</a>
        </div>
    @else
        <nav class="navbar navbar-expand-md">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item padding-right">
                    <p> <i class="fa fa-square upcoming"></i> Upcoming</p>
                </li>
                <li class="nav-item padding-right">
                    <p> <i class="fa fa-square complete"></i> Complete</p>
                </li>
                <li class="nav-item padding-right">
                    <p> <i class="fa fa-square overdue"></i> Overdue</p>
                </li>
            </ul>
        </nav>
    @endif
    <div id="calendar"></div>
@endsection
