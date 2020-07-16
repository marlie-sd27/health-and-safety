@extends('layout')

@section('content')
    <a href="{{ route('submissions.index') }}">Back to Index</a>
    <a class="float-right" href="{{ route('submissions.edit', ['submission' => $submission->id]) }}">Edit</a>
    <div class="container" name="submission-meta-info">
        <h2>{{ $submission->form->title }}</h2>
        <table class="table table-bordered">
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
        <table class="table table-bordered">
            @foreach($submission->form->sections as $section)
                <tr>
                    <th colspan="2">{{ $section->title }}</th>
                </tr>
                @foreach($section->fields as $field)
                    <tr>
                        <td><b>{{ $field->label }}</b></td>
                        <td>{{ $submission->data[$field->label] }}</td>
                    </tr>
                @endforeach
            @endforeach
        </table>
    </div>


@endsection
