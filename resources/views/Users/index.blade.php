@extends('layout')

@section('content')
    <a href="{{ url()->previous() }}">Back</a>
    <div class="container">
        <h1>List Users</h1>
        <p>
            Here you'll find all the users that have logged into this system. If they have logged in since October 19,
            2020, it will include their position and department if those attributes are available.
        </p>
        <p><b>
                Users who are no longer working for the school district will also be listed until they are manually deleted from here.</b>
        </p>
        <div class="row">
            <table class="table table-bordered table-hover container">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Site</th>
                    <th>Job Title</th>
                </tr>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->getDisplayName() }}</td>
                        <td>{{ $user->getMail() }}</td>
                        <td>{{ $user->getDepartment() }}</td>
                        <td>{{ $user->getJobTitle() }}</td>
                    </tr>
                @endforeach
            </table>
        </div>

        @if($next)
            <a href="{{ route('retrieve', ['next' => $next]) }}">Next Page</a>
        @endif


    </div>

@endsection
