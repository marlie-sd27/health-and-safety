@extends('layout')

@section('content')
    <div>
        <table>
            <tr>
                <th>ID</th>
                <th>Form</th>
                <th>User Name</th>
                <th>User Email</th>
                <th>Data</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>

            @foreach($submissions as $submission)
                <tr>
                    <td>{{ $submission->id }}</td>
{{--                    <td><a href="{{ route('submissions.show', ['submission' => $submission]) }}">{{ $submission->form->title }}</a></td>--}}
                    <td>{{ $submission->username }}</td>
                    <td>{{ $submission->email }}</td>
                    <td>{{ $submission->data }}</td>
                    <td><a href="{{ route('submissions.edit', ['$submission' => $submission->id]) }}">Edit</a></td>
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
