@extends('layout')

@section('content')
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
                    @foreach( $upcomings as $upcoming)
                        <li><a href="{{ route('forms.show', ['form' => $upcoming->forms->id]) }}">{{ $upcoming->forms->title }}</a> is due <b>{{ \App\Helpers\Helper::makeDateReadable($upcoming->date) }}</b></li>
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
@endsection
