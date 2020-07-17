@extends('layout')

@section('content')
    <div>
        <table class="table table-bordered">
            <tr>
                <th>ID</th>
                <th>Form</th>
                <th>Submitter Name</th>
                <th>View Submission</th>
                <th>Delete</th>
            </tr>

            @foreach($submissions as $submission)
                <tr>
                    <td>{{ $submission->id }}</td>
                    <td><a href="{{ route('forms.show', ['form' => $submission->forms]) }}">{{ $submission->forms->title }}</a></td>
                    <td>{{ $submission->username }}</td>
                    <td><a href="{{ route('submissions.show', ['submission' => $submission]) }}">View</a></td>
                    @can('delete', $submission)
                        <td>
                        <form method="post" class="delete_form" action="{{route('submissions.destroy', $submission->id)}}">
                            @csrf
                            @method('delete')
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                    @endcan
                </tr>
            @endforeach
        </table>

    </div>

@endsection
