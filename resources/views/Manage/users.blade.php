@extends('layout')

@section('content')
    <a href="{{ url()->previous() }}">Back</a>
    <div class="container">
        <h1>Manage Users</h1>
        <p>
            Here you'll find all the users that have logged into this system. If they have logged in since October 19,
            2020, it will include their position and department if those attributes are available.
        </p>
        <p><b>
            Users who are no longer working for the school district will also be listed until they are manually deleted from here.</b>
        </p>
        <div class="row">
            <article class="container">
                <form method="get" action="{{ route('users') }}">
                        <input class="form-control" type="text" placeholder="Search for a user" name='name'
                               value="{{ $name ?? ""}}"
                               aria-label="Search"/>
                </form>

            </article>
            <table class="table table-bordered table-hover container">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Site</th>
                    <th>Job Title</th>
                    <th>Admin</th>
                    <th>Last Login</th>
                    <th>Delete</th>
                </tr>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->site }}</td>
                        <td>{{ $user->job_title }}</td>
                        <td>{{ $user->admin ? 'true' : 'false' }}</td>
                        <td>{{ date('M d, Y @ H:i a', strtotime($user->last_login)) }}</td>
                        <td>
                            <form method="post"
                                  class="delete_form"
                                  action="{{route('users.destroy', $user->id)}}">
                                @csrf
                                @method('delete')
                                <button type="submit" onclick="return confirm('Are you sure?')" class="border-0">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
        <p class="text-center">{{ $users->links() }}</p>

    </div>

@endsection
