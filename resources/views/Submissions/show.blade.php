@extends('layout')

@section('content')


    <a href="{{ url()->previous() }}">Back</a>
    @can('update',  $submission)
        <a class="float-right" href="{{ route('submissions.edit', ['submission' => $submission->id]) }}">Make Changes to
            My Submission</a>
    @endcan
    <div class="container">
        <h2>{{ $submission->form->title }}</h2>
        @if(isset($submission->events->date))
            <h3>Due: {{ App\Helpers\Helper::makeDateReadable($submission->events->date) }}</h3>
        @endif
        <table class="table table-bordered table-hover">
            <tr>
                <th>School/Site</th>
                <th>Submitted By</th>
                <th>Submitter's email</th>
                <th>Date Submitted</th>
                <th>Last Updated</th>
            </tr>
            <tr>
                <td>{{ $submission->site }}</td>
                <td>{{ $submission->users->name }}</td>
                <td>{{ $submission->email }}</td>
                <td>{{ $submission->created_at_readable }}</td>
                <td>{{ $submission->updated_at_readable }}</td>
            </tr>
        </table>
    </div>
    <div class="container">
        <table class="table table-bordered table-hover">
            @foreach($submission->form->sections as $section)
                <tr>
                    <th colspan="2" class="text-center">{{ $section->title }}</th>
                </tr>

                @foreach($section->fields as $field)
                    <tr>
                        <td>{{ $field->label }}</td>
                        <td>{{ $submission->data[$field->name] ?? "" }}</td>
                    </tr>
                @endforeach
            @endforeach
        </table>
    </div>


@endsection
