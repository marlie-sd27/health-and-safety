@extends('layout')

@section('content')
    <div>
        <table>
            <tr>
                <th>ID</th>
                <th>Form</th>
                <th>User Name</th>
                <th>User Email</th>
                <th>View Submission</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>

            @foreach($submissions as $submission)
                <tr>
                    <td>{{ $submission->id }}</td>
                    <td><a href="{{ route('submissions.show', ['submission' => $submission]) }}">{{ $submission->forms->title }}</a></td>
                    <td>{{ $submission->username }}</td>
                    <td>{{ $submission->email }}</td>
                    <td><a href="{{ route('submissions.show', ['submission' => $submission]) }}">View</a></td>
                    <td><a href="{{ route('submissions.edit', ['submission' => $submission]) }}">Edit</a></td>
                    <td>
                        <form method="post" class="delete_form" action="{{route('submissions.destroy', $submission->id)}}">
                            @csrf
                            @method('delete')
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>

    </div>

@endsection
