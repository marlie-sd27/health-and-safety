@extends('layout')

@section('content')

    <a href="{{ url()->previous() }}">Back</a>
    <div class="container">
        <h1>Website Admins</h1>
        <p>These users have administrator access to this website, which allows them to view all upcoming and overdue
            deadlines, create, edit and delete forms, and export submission reports. Admins can also add and delete
            other site admins</p>
        <article class="container">
            <form method="post" action="{{ route('admins.store') }}">
                @csrf
                <div class="form-group">
                    <label>Enter an email to assign as website admin:
                        <input type="text" placeholder="Enter Email" class="form-control" name="email"/>
                    </label>
                </div>
                <button class="btn btn-primary" type="submit">Enter</button>
            </form>
        </article>
        <table class="table table-bordered table-hover">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th class="w-25">Delete</th>
            </tr>
            @foreach( $admins as $admin)
                <tr>
                    <td>{{ $admin->name }}</td>
                    <td>{{ $admin->email }}</td>
                    <td class="w-25">
                        <form method="post" class="delete_form"
                              action="{{route('admins.destroy', $admin->id)}}">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-secondary" onclick="return confirm('Are you sure?')">
                                Remove Admin
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

@endsection
