@extends('layout')

@section('content')

    <a href="{{ url()->previous() }}">Back</a>
    @if($admin)
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
                <td>{{ Carbon\Carbon::now()->diffInDays($training->expiry_date, false) }} days</td>
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
                <th>Inspection Date</th>
                <td>{{ date('M d, Y', strtotime($training->inspection_date)) }}</td>
            </tr>
            <tr>
                <th>Designated First Aid Attendant?</th>
                <td>{{ $training->designated_fa_attendant ? "True" : "False" }}</td>
            </tr>
            <tr>
                <th>Union</th>
                <td>{{ $training->union }}</td>
            </tr>
            <tr>
                <th>Level of First Aid</th>
                <td>{{ $training->fa_level }}</td>
            </tr>
            <tr>
                <th>Full/Part Time/Hours</th>
                <td>{{ $training->full_part_hours }}</td>
            </tr>
            <tr>
            <tr>
            <th>Training Entry Date</th>
            <td>{{ date('M d, Y @ H:i a', strtotime($training->created_at)) }}</td>
            </tr>
                <th>Notes</th>
                <td>{{ $training->notes }}</td>
            </tr>
        </table>
    </div>


@endsection
