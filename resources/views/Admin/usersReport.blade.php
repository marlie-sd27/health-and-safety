@extends('layout')

@section('content')
    <div>
        <table id="users" class="table table-bordered">
            <tr>
                <th>ID</th>
                <th>Form</th>
                <th>Submitter Name</th>
                <th>Date Submitted</th>
                <th>View Submission</th>
                <th>Delete</th>
            </tr>


            @foreach($submissions as $submission)
                <tr class="row-data">
                    <td>{{ $submission->id }}</td>
                    <td>{{ $submission->forms->title }}</td>
                    <td>{{ $submission->username }}</td>
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

        <div class="wrapper">
            <p>Search for Submissions by user: </p>

            <input id="searchUser" class="form-control" type="text" placeholder="Search"
                   aria-label="Search"/>
        </div>


    </div>

@endsection
