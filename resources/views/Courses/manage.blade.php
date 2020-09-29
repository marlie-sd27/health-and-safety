@extends('layout')

@section('content')
    <a href="{{ url()->previous() }}">Back</a>
    <div class="container">
        <h1>Manage Courses</h1>
        <p>
            Here you'll find a list of all the courses. These courses are listed in drop down
            menus of training entries. Add new courses and delete old courses.
        </p>
        <div class="row">
            <table class="table table-bordered table-hover col-5 container">
                @foreach($courses as $course)
                    <tr>
                        <td>{{ $course->course }}
                            <form method="post"
                                  class="delete_form float-right"
                                  action="{{route('courses.destroy', $course->id)}}">
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
                <h2>Add a New Course</h2>
                <form action="{{ route('courses.store') }}" method="post">
                    @csrf
                    <input type="text" name="course" class="form-control" placeholder="Course Name">
                    <div class="container align-content-center">
                        <button class="btn btn-block btn-sm btn-success" type="submit">Save</button>
                    </div>
                </form>
            </article>
        </div>

    </div>

@endsection
