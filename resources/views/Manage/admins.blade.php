@extends('layout')

@section('content')

    <a href="{{ url()->previous() }}">Back</a>
    <div class="container">
        <h1>Website Admins</h1>
        <p>These users have administrator access to this website, which allows them to view all upcoming and overdue
            deadlines, create, edit and delete forms, and export submission reports. Admins can also add and delete
            other site admins</p>
        <div class="row">
            <table class="table table-bordered table-hover col-5 container">
                @foreach($admins as $admin)
                    <tr>
                        <td>{{ $admin->email }}
                            <form method="post"
                                  class="delete_form float-right"
                                  action="{{route('admins.destroy', $admin->id)}}">
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
                <h2>Add a New Admin</h2>
                <form action="{{ route('admins.store') }}" method="post">
                    @csrf
                    <input type="text" name="email" class="form-control" placeholder="Enter Email">
                    <div class="container align-content-center">
                        <button class="btn btn-block btn-sm btn-success" type="submit">Save</button>
                    </div>
                </form>
            </article>
        </div>
    </div>

@endsection
