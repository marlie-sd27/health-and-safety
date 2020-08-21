@extends('layout')

@section('content')
    <a href="{{ url()->previous() }}">Back</a>
    <div>
        @if(!$form)
            <div class="alert alert-primary">
                <p>Exports are only available when a form is specified in the search parameters</p>
            </div>
        @endif
        <article class="container">
            <form method="get" action="{{ route('report') }}">
                <label>Search by form:
                    <select class="form-control text-reset" type="text" name='form'
                            aria-label="Search">
                        <option></option>
                        @foreach($links as $link)
                            <option @if ($form == $link->title) {{ 'selected' }} @endif>{{ $link->title }}</option>
                        @endforeach
                    </select>
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
                <label>Search by user:
                    <input class="form-control" type="text" placeholder="Search" name='user'
                           value="{{ $user ?? ""}}"
                           aria-label="Search"/>
                </label>
                <label>Search from date:
                    <input class="form-control text-reset" type="date" placeholder="Search" name='date_from'
                           value="{{ $date_from ?? "" }}"
                           aria-label="Search"/>
                </label>
                <label>to date:
                    <input class="form-control text-reset" type="date" placeholder="Search" name='date_to'
                           value="{{ $date_to ?? "" }}"
                           aria-label="Search"/>
                </label>

                <button class="btn btn-primary" type="submit">Search</button>
                <button class="btn btn-dark" type="button" id="clear">Clear Search Fields</button>

                @if($form)
                    <a href="{{ route('export', ['form'=>$form, 'user'=>$user, 'site'=>$site, 'date_from'=>$date_from, 'date_to'=>$date_to]) }}"
                       class="btn btn-success">Export</a>
                @endif
            </form>

        </article>
        <table id="users" class="table table-bordered table-hover">
            <tr>
                <th>Form</th>
                <th>School/Site</th>
                <th>User</th>
                <th>Date Submitted</th>
                <th>View Submission</th>
                @if(Auth::user()->isAdmin())
                    <th>Delete</th>@endif
            </tr>

            @foreach($submissions as $submission)
                <tr class="row-data">
                    <td>{{ $submission->forms->title }}</td>
                    <td>{{ $submission->site }}</td>
                    <td>{{ $submission->users->name }}</td>
                    <td>{{ date('M d, Y @ H:i a', strtotime($submission->created_at)) }}</td>
                    <td><a href="{{ route('submissions.show', ['submission' => $submission]) }}">View</a></td>
                    @if(Auth::user()->isAdmin())
                        <td>
                            <form method="post" class="delete_form"
                                  action="{{route('submissions.destroy', $submission->id)}}">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-secondary" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    @endif
                </tr>
            @endforeach
        </table>
    </div>

@endsection
