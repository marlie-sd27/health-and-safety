@extends('layout')

@section('content')
    <div>
        <table class="table table-bordered table-hover">
            <tr>
                <th>Form</th>
                <th>School/Site</th>
                <th>Date Submitted</th>
                <th>View Submission</th>
            </tr>

            @foreach($submissions as $submission)
                <tr>
                    <td>{{ $submission->forms->title }}</td>
                    <td>{{ $submission->site }}</td>
                    <td>{{ date('M d, Y @ H:i a', strtotime($submission->created_at)) }}</td>
                    <td><a href="{{ route('submissions.show', ['submission' => $submission]) }}">View</a></td>
                </tr>
            @endforeach
        </table>

    </div>

@endsection
