@extends('layout')

@section('content')
    <a href="{{ url()->previous() }}">Back</a>
    <div class="container">
        <h1>My Submissions</h1>
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
                    <td>{{ $submission->sites->site }}</td>
                    <td>{{ date('M d, Y @ H:i a', strtotime($submission->created_at)) }}</td>
                    <td><a href="{{ route('submissions.show', ['submission' => $submission]) }}">View</a></td>
                </tr>
            @endforeach
        </table>

    </div>

@endsection
