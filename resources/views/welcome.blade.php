@extends('layout')

@section('content')
    <div>
        @if(isset($userName))
            <h1>{{ $userName }}'s Dashboard</h1>
            <div class="container">
                <div class="row">
                    <div class="col-md card">
                        <h2>Overdue</h2>
                        <ul>
                            @foreach( $overdues as $key => $value)
                                <li>{{ $key }} was due {{ $value }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-md card">
                        <h2>Upcoming</h2>
                        <ul>
                            @foreach( $upcomings as $key => $value)
                                <li>{{ $key }} is due {{ $value }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg card">
                        <h2>Completed</h2>
                        <ul>
                            @foreach( $completed as $key => $value)
                                <li>{{ $key }} was completed {{ $value }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>


        @else
            <a href="/signin" class="btn btn-primary btn-large">Click here to sign in</a>
        @endif
    </div>
@endsection
