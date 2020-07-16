@extends('layout')

@section('content')
    <div class="container" name="submission-meta-info">
        <h2>{{ $submission->form->title }}</h2>
        <table class="table-bordered">
            <tr>
                <th>Submitted By</th>
                <th>Submitter's email</th>
                <th>Date Submitted</th>
                <th>Last Updated</th>
            </tr>
            <tr>
                <td>{{ $submission->username }}</td>
                <td>{{ $submission->email }}</td>
                <td>{{ date('M d, Y @ H:i a', strtotime($submission->created_at)) }}</td>
                <td>{{ date('M d, Y @ H:i a', strtotime($submission->updated_at)) }}</td>
            </tr>
        </table>
    </div>
    <div class="container" name="form">
        @foreach($submission->form->sections as $section)

        @endforeach
    </div>


@endsection
