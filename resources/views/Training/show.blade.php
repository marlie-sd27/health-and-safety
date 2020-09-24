@extends('layout')

@section('content')

    <a href="{{ url()->previous() }}">Back</a>
    @if(Auth::user()->isAdmin())
        <a class="float-right" href="{{ route('training.edit', ['training' => $training->id]) }}">Edit</a>
    @endcan
    <div class="container">
        <h2>{{ $training->course }}</h2>
        <p>{{ $training->description }}</p>
        <table class="table table-bordered table-hover">
            <tr>
                <th>Employee</th>
                <td>{{ $training->users->name ?? $training->email}}</td>
            </tr>
            <tr>
                <th>School/Site</th>
                <td>{{ $training->site }}</td>
            </tr>
            <tr>
                <th>Expires In</th>
                <td>TODO</td>
            </tr>
            <tr>
                <th>Course Date</th>
                <td>{{ date('M d, Y', strtotime($training->course_date)) }}</td>
            </tr>
            <tr>
                <th>Expiry Date</th>
                <td>{{ date('M d, Y', strtotime($training->expiry_date)) }}</td>
            </tr>
            <tr>
                <th>Training Entry Date</th>
                <td>{{ date('M d, Y @ H:i a', strtotime($training->created_at)) }}</td>
            </tr>
            <tr>
                <th>Notes</th>
                <td>{{ $training->notes }}</td>
            </tr>
        </table>
    </div>


@endsection
