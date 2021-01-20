@extends('layout')

@section('content')

    <script src="{{ asset('/js/calendar.js') }}"></script>
    @if($admin || $report_access)
        <div class="container">
            <a href="{{ route('events') }}">List all event deadlines..</a>
        </div>
        <nav class="navbar navbar-expand-md">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item padding-right">
                    <p> <i class="fa fa-square blue"></i> Form Deadlines</p>
                </li>
                <li class="nav-item padding-right">
                    <p> <i class="fa fa-square purple"></i> Training Expiration</p>
                </li>
            </ul>
        </nav>
    @else
        <nav class="navbar navbar-expand-md">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item padding-right">
                    <p> <i class="fa fa-square blue"></i> Upcoming</p>
                </li>
                <li class="nav-item padding-right">
                    <p> <i class="fa fa-square green"></i> Complete</p>
                </li>
                <li class="nav-item padding-right">
                    <p> <i class="fa fa-square orange"></i> Overdue</p>
                </li>
                <li class="nav-item padding-right">
                    <p> <i class="fa fa-square purple"></i> Training</p>
                </li>
            </ul>
        </nav>
    @endif
    <div id="calendar"></div>
@endsection
