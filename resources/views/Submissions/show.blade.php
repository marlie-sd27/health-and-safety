@extends('layout')

@section('content')

    @if(Auth::user()->isAdmin())
        <a href="{{ route('admin.submissions.index') }}">Back</a>
    @else
        <a href="{{ route('submissions.index') }}">Back</a>
    @endif

    @can('update',  $submission)
        <a class="float-right" href="{{ route('submissions.edit', ['submission' => $submission->id]) }}">Make Changes to My Submission</a>
    @endcan
    <div class="container">
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
                <td>{{ $submission->created_at_readable }}</td>
                <td>{{ $submission->updated_at_readable }}</td>
            </tr>
        </table>
    </div>
    <div class="container">
        <table class="table table-bordered">
            @foreach($submission->form->sections as $section)
                <tr>
                    <th colspan="2" class="text-center">{{ $section->title }}</th>
                </tr>
                <tr>
                    <th>Field</th>
                    <th>Value</th>
                </tr>
                @foreach($section->fields as $field)
                    <tr>
                        <td>{{ $field->label }}</td>
                        <td>{{ $submission->data[$field->label] ?? "" }}</td>
                    </tr>
                @endforeach
            @endforeach
        </table>
    </div>


@endsection
