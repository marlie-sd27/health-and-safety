@extends('layout')

@section('content')
    <div>
        <a href="{{ url()->previous() }}">Back</a>
        <table class="table table-bordered table-hover">
            <tr>
                <th>Course</th>
                <th>School/Site</th>
                <th>Expires In</th>
                <th>Course Date</th>
                <th>Expiry Date</th>
                <th>View</th>
            </tr>

            @foreach($trainings as $training)
                <tr>
                    <td>{{ $training->course }}</td>
                    <td>{{ $training->site }}</td>
                    <td>TODO</td>
                    <td>{{ date('M d, Y', strtotime($training->course_date)) }}</td>
                    <td>{{ date('M d, Y', strtotime($training->expiry_date)) }}</td>
                    <td><a href="{{ route('training.show', ['training' => $training]) }}">View</a></td>
                </tr>
            @endforeach
        </table>

    </div>

@endsection
