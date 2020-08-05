@extends('layout')

@section('content')
    <div>
        <article class="container">
            <p>Search for Submissions by user: </p>

            <input id="searchUser" class="form-control" type="text" placeholder="Search"
                   aria-label="Search"/>
        </article>
        <table id="users" class="table table-bordered">
            <tr>
                <th>Form</th>
                <th>School/Site</th>
                <th>Submitter Name</th>
                <th>Date Submitted</th>
                <th>View Submission</th>
                <th>Delete</th>
            </tr>

            @foreach($submissions as $submission)
                <tr class="row-data">
                    <td>{{ $submission->forms->title }}</td>
                    <td>{{ $submission->site }}</td>
                    <td>{{ $submission->user->name }}</td>
                    <td>{{ date('M d, Y @ H:i a', strtotime($submission->created_at)) }}</td>
                    <td><a href="{{ route('submissions.show', ['submission' => $submission]) }}">View</a></td>
                    @can('delete', $submission)
                        <td>
                            <form method="post" class="delete_form"
                                  action="{{route('submissions.destroy', $submission->id)}}">
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
