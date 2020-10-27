@extends('layout')

@section('content')

    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <a href="{{ url()->previous() }}">Back</a>
    @can('update',  $submission)
        <a class="float-right" href="{{ route('submissions.edit', ['submission' => $submission->id]) }}"><i class="fa fa-pencil-alt"></i> Edit </a>
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
                    <th colspan="2">{{ $section->title }}</th>
                </tr>

                @foreach($section->fields as $field)
                    <tr>
                        <td class="w-50">{{ $field->label }}</td>
                        @if($field->type == "file")
                            @if( isset($submission->files[trim($field->name)]) && Storage::exists($submission->files[trim($field->name)]))
                            <td class="w-50">
                                <form method="post" action="/file">
                                    @csrf
                                    <input type="hidden" name="file" value="{{ $submission->files[trim($field->name)] }}"/>
                                    <button type='submit' class="btn btn-primary">Click here to download</button>
                                </form>
                            </td>
                            @else
                                <td class="w-50">No file available</td>
                            @endif
                        @else
                            <td class="w-50">{{ $submission->data[trim($field->name)] ?? "" }}</td>
                        @endif
                    </tr>
                @endforeach
            @endforeach
        </table>
    </div>


@endsection
