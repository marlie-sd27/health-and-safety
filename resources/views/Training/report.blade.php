@extends('layout')

@section('content')
    <div>
        <a href="{{ url()->previous() }}">Back</a>
        <article class="container">
            <form method="get" action="{{ route('training.report') }}">
                <label>Search by course:
                    <input class="form-control text-reset" type="text" name='course'
                           value="{{ $course ?? ""}}"
                           aria-label="Search">
                </label>
                <label>Search by site:
                    <select class="form-control text-reset" type="text" name='site'>
                        <option @if ($site == "") {{ 'selected' }} @endif></option>
                        <option @if ($site == "100 Mile Elementary") {{ 'selected' }} @endif>100 Mile Elementary
                        </option>
                        <option @if ($site == "100 Mile Maintenance") {{ 'selected' }} @endif>100 Mile Maintenance
                        </option>
                        <option @if ($site == "150 Mile Elementary") {{ 'selected' }} @endif>150 Mile Elementary
                        </option>
                        <option @if ($site == "Alexis Creek") {{ 'selected' }} @endif>Alexis Creek</option>
                        <option @if ($site == "Anahim") {{ 'selected' }} @endif>Anahim</option>
                        <option @if ($site == "Big Lake") {{ 'selected' }} @endif>Big Lake</option>
                        <option @if ($site == "Board Office") {{ 'selected' }} @endif>Board Office</option>
                        <option @if ($site == "Cataline") {{ 'selected' }} @endif>Cataline</option>
                        <option @if ($site == "Chilcotin Road") {{ 'selected' }} @endif>Chilcotin Road</option>
                        <option @if ($site == "Dog Creek") {{ 'selected' }} @endif>Dog Creek</option>
                        <option @if ($site == "Forest Grove") {{ 'selected' }} @endif>Forest Grove</option>
                        <option @if ($site == "Horse Lake") {{ 'selected' }} @endif>Horse Lake</option>
                        <option @if ($site == "Horsefly") {{ 'selected' }} @endif>Horsefly</option>
                        <option @if ($site == "GROW WL") {{ 'selected' }} @endif>GROW WL</option>
                        <option @if ($site == 'Lac La Hache') {{ 'selected' }} @endif>Lac La Hache</option>
                        <option @if ($site == "LCS-Williams Lake") {{ 'selected' }} @endif>LCS-Williams Lake</option>
                        <option @if ($site == "LCS-Columneetza") {{ 'selected' }} @endif>LCS-Columneetza</option>
                        <option @if ($site == "Likely") {{ 'selected' }} @endif>Likely</option>
                        <option @if ($site == "Marie Sharpe") {{ 'selected' }} @endif>Marie Sharpe</option>
                        <option @if ($site == "Mile 108 Elementary") {{ 'selected' }} @endif>Mile 108 Elementary
                        </option>
                        <option @if ($site == "Mountview") {{ 'selected' }} @endif>Mountview</option>
                        <option @if ($site == "Maintenance Yard") {{ 'selected' }} @endif>Maintenance Yard</option>
                        <option @if ($site == "Naughtaneqed") {{ 'selected' }} @endif>Naughtaneqed</option>
                        <option @if ($site == "Nenqayni") {{ 'selected' }} @endif>Nenqayni</option>
                        <option @if ($site == "Nesika") {{ 'selected' }} @endif>Nesika</option>
                        <option @if ($site == "PSO") {{ 'selected' }} @endif>PSO</option>
                        <option @if ($site == "Support Services") {{ 'selected' }} @endif>Support Services</option>
                        <option @if ($site == "Tatla Lake") {{ 'selected' }} @endif>Tatla Lake</option>
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

{{--                <a href="{{ route('export', ['course'=>$course, 'user'=>$user, 'site'=>$site, 'expiry_date'=>$expiry_date, 'course_date'=>$course_date]) }}"--}}
{{--                   class="btn btn-success">Export</a>--}}
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
                @if(Auth::user()->isAdmin())
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
                    @if(Auth::user()->isAdmin())
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
