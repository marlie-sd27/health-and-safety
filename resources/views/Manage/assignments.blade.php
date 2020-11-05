@extends('layout')

@section('content')

    <a href="{{ url()->previous() }}">Back</a>
    <div class="container">
        <h1>Assignments</h1>
        <p>These are all the assignments for users or sites to complete form submissions by a certain deadline.</p>
        <div class="row">
            <table class="table table-bordered table-hover col-5 container">
                @foreach($assignments as $assignment)
                    <tr>
                        <td>{{ $assignment->email }}
                            <form method="post"
                                  class="delete_form float-right"
                                  action="{{route('assignments.destroy', $assignment->id)}}">
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
                <h2>Add a New Assignment</h2>
                <form action="{{ route('assignments.store') }}" method="post">
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
