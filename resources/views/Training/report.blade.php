@extends('layout')

@section('content')
    <div>
        <a href="{{ url()->previous() }}">Back</a>
        <article class="container">
            <form method="get" action="{{ route('training.report') }}">
                <h2>Search Filters</h2>
                <div class="row">
                    <label class="col-2">Course:
                        <select class="form-control text-reset" name='course'>
                            <option @if ($course == "") {{ 'selected' }} @endif></option>
                            @foreach($courses as $_course)
                                <option @if ($course == $_course->course) {{ 'selected' }} @endif>{{ $_course->course }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="col-2">Site:
                        <select class="form-control text-reset" name='site'>
                            <option @if ($site == "") {{ 'selected' }} @endif></option>
                            @foreach($sites as $_site)
                                <option @if ($site == $_site->site) {{ 'selected' }} @endif>{{$_site->site}}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="col-2">User:
                        <input class="form-control" type="text" placeholder="Search" name='email'
                               value="{{ $email ?? ""}}"
                               aria-label="Search"/>
                    </label>
                    <label class="col-2">Expiry Date From:
                        <input class="form-control text-reset" type="date" placeholder="Search" name='expiry_date_from'
                               value="{{ $expiry_date_from ?? "" }}"
                               aria-label="Search"/>
                    </label>
                    <label class="col-2">Expiry Date To:
                        <input class="form-control text-reset" type="date" placeholder="Search" name='expiry_date_to'
                               value="{{ $expiry_date_to ?? "" }}"
                               aria-label="Search"/>
                    </label>
                    <label class="col-2">Course Date:
                        <input class="form-control text-reset" type="date" placeholder="Search" name='course_date'
                               value="{{ $course_date ?? "" }}"
                               aria-label="Search"/>
                    </label>
                </div>

                <div class="row container">
                    <div class="col-4">
                        <button class="btn btn-primary w-100" type="submit">Search</button>
                    </div>
                    <div class="col-4 ">
                        <button class="btn btn-dark w-100" type="button" id="clear">Clear Search Fields</button>
                    </div>
                    <div class="col-4">
                        <a href="{{ route('training.export', ['course'=>$course, 'email'=>$email, 'site'=>$site, 'expiry_date_from'=>$expiry_date_from, 'expiry_date_to'=>$expiry_date_to, 'course_date' => $course_date]) }}"
                           class="btn btn-success w-100">Export</a>
                    </div>
                </div>
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
                    <th></th>@endif
            </tr>

            @foreach($trainings as $training)
                <tr class="row-data">
                    <td>{{ $training->course }}</td>
                    <td>{{ str_replace(['@sd27.bc.ca','.'], ' ', $training->email) }}</td>
                    <td>{{ $training->site }}</td>
                    <td>{{ $training->expiry_date ? Carbon\Carbon::now()->diffInDays($training->expiry_date, false) . " days" : "N/A"}}</td>
                    <td>{{ date('M d, Y', strtotime($training->course_date)) }}</td>
                    <td>{{ $training->expiry_date ? date('M d, Y', strtotime($training->expiry_date)) : ""}}</td>
                    <td><a href="{{ route('training.show', ['training' => $training]) }}">View</a></td>
                    @if($admin)
                        <td>
                            <form method="post" class="delete_form"
                                  action="{{route('training.destroy', $training->id)}}">
                                @csrf
                                @method('delete')
                                <button type="submit" class="border-0" onclick="return confirm('Are you sure?')">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    @endif
                </tr>
            @endforeach
        </table>
        <div>
            {{ $trainings->appends([
            'trainings' => $trainings,
            'email' => $email,
            'site' => $site,
            'course' => $course,
            'course_date' => $course_date,
            'expiry_date_from' => $expiry_date_from,
            'expiry_date_to' => $expiry_date_to,
            ])->links() }}
        </div>
    </div>
@endsection
