@extends('layout')

@section('content')
    <div>
        <article class="container">


            <form method="get" action="{{ route('report') }}">
                <label>Search by user:
                    <input class="form-control" type="text" placeholder="Search" name='user'
                           value="{{ $user ?? ""}}"
                           aria-label="Search"/>
                </label>
                <label>Search by site:
                    <input class="form-control text-reset" type="text" placeholder="Search" name='site'
                           value="{{ $site ?? "" }}"
                           aria-label="Search"/>
                </label>
                <label>Search by form:
                    <input class="form-control text-reset" type="text" placeholder="Search" name='form'
                           value="{{ $form ?? "" }}"
                           aria-label="Search"/>
                </label>
                <button class="btn btn-primary" type="submit">Search</button>
                <button class="btn btn-dark" type="button" id="clear">Clear Search Fields</button>
            </form>
        </article>
        <table id="users" class="table table-bordered">
            <tr>
                <th>Form</th>
                <th>School/Site</th>
                <th>User</th>
                <th>Date Submitted</th>
                <th>View Submission</th>
                <th>Delete</th>
            </tr>

            @foreach($submissions as $submission)
                <tr class="row-data">
                    <td>{{ $submission->forms->title }}</td>
                    <td>{{ $submission->site }}</td>
                    <td>{{ $submission->users->name }}</td>
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
