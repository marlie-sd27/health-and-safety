@extends('layout')

@section('content')
    <div>
        <a href="{{ url()->previous() }}">Back</a>
        <article class="container">
            <form method="get" action="{{ route('training.report') }}">
                <label>Search by course:
                    <select class="form-control text-reset" name='course'>
                        <option @if ($course == "") {{ 'selected' }} @endif></option>
                        @foreach($courses as $_course)
                            <option @if ($course == $_course->course) {{ 'selected' }} @endif>{{ $_course->course }}</option>
                        @endforeach
                    </select>
                </label>
                <label>Search by site:
                    <select class="form-control text-reset" name='site'>
                        <option @if ($site == "") {{ 'selected' }} @endif></option>
                        @foreach($sites as $_site)
                            <option @if ($site == $_site->site) {{ 'selected' }} @endif>{{$_site->site}}</option>
                        @endforeach
                    </select>
                </label>
                <label>Search by email:
                    <input class="form-control" type="text" placeholder="Search" name='email'
                           value="{{ $user ?? ""}}"
                           aria-label="Search"/>
                </label>
                <label>Search by course date:
                    <input class="form-control text-reset" type="date" placeholder="Search" name='course_date'
                           value="{{ $course_date ?? "" }}"
                           aria-label="Search"/>
                </label>
                <label>Search by expiry date:
                    <input class="form-control text-reset" type="date" placeholder="Search" name='expiry_date'
                           value="{{ $expiry_date ?? "" }}"
                           aria-label="Search"/>
                </label>

                <button class="btn btn-primary" type="submit">Search</button>
                <button class="btn btn-dark" type="button" id="clear">Clear Search Fields</button>
            </form>

        </article>
        <table id="users" class="table table-bordered table-hover">
            <tr>
                <th>Course</th>
                <th>User</th>
                <th>School/Site</th>
                <th>Expires In</th>
                <th>Course Date</th>
                <th>Expiry Date</th>
                <th>View</th>
                @if($admin)
                    <th>Delete</th>@endif
            </tr>

            @foreach($trainings as $training)
                <tr class="row-data">
                    <td>{{ $training->course }}</td>
                    <td>{{ $training->users->name ?? $training->email}}</td>
                    <td>{{ $training->site }}</td>
                    <td>{{ Carbon\Carbon::now()->diffInDays($training->expiry_date, false) }} days</td>
                    <td>{{ date('M d, Y', strtotime($training->course_date)) }}</td>
                    <td>{{ date('M d, Y', strtotime($training->expiry_date)) }}</td>
                    <td><a href="{{ route('training.show', ['training' => $training]) }}">View</a></td>
                    @if($admin)
                        <td>
                            <form method="post" class="delete_form"
                                  action="{{route('training.destroy', $training->id)}}">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-secondary"
                                        onclick="return confirm('Are you sure?')">Delete
                                </button>
                            </form>
                        </td>
                    @endif
                </tr>
            @endforeach
        </table>
        <div>
            {{ $trainings->links() }}
        </div>
    </div>
@endsection
