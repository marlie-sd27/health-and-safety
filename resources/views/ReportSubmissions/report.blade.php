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
            <form method="get" action="{{ route('submissions.report') }}">
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
                        @foreach($sites as $_site)
                            <option @if($site == $_site->site) {{ 'selected' }} @endif>{{ $_site->site}}</option>
                        @endforeach
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
                    <a href="{{ route('submissions.export', ['form'=>$form, 'user'=>$user, 'site'=>$site, 'date_from'=>$date_from, 'date_to'=>$date_to]) }}"
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
                    @if($admin)
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
            <div>
                {{ $submissions->links() }}
            </div>
    </div>

@endsection
