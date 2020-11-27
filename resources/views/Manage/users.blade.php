@extends('layout')

@section('content')
    <a href="{{ url()->previous() }}">Back</a>
    <div class="container">
        <h1>All Staff</h1>
        <p>
            Here you'll find all the staff in School District No. 27.
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
        <p class="text-center">{{ $users->links() }}</p>

    </div>

@endsection
