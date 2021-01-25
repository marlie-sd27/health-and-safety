@extends('layout')

@section('content')
    <a href="{{ url()->previous() }}">Back</a>
    <div class="container">
        <h1>Manage Users with Reporting Privileges</h1>
        <p>
            These users have access to view all submissions, upcoming deadlines and overdue assignments. They can search for submissions like principals and administrators,
            but they are unable to create, edit or delete forms. In addition, they have no access to anything under the "Manage"
            drop down tab.
        </p>
        <div class="row">
            <table class="table table-bordered table-hover col-5 container">
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->email }}
                            <form method="post"
                                  class="delete_form float-right"
                                  action="{{route('reporters.destroy', $user->id)}}">
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
            <article class="col-4 text-center container" id="create">
                <h2>Grant Privileges to User</h2>
                <form action="{{ route('reporters.store') }}" method="post">
                    @csrf
                    <input class="form-control @error('email') border-danger @enderror"
                           type="text"
                           name="email"
                           placeholder="Enter Email"
                           required
                           value="{{ old('email') }}">
                    @error('email')
                    <p class="text-danger">{{ $errors->first('email') }}</p>
                    @enderror
                    <div class="container align-content-center">
                        <button class="btn btn-block btn-sm btn-success" type="submit">Save</button>
                    </div>
                </form>
            </article>
        </div>

    </div>

@endsection
