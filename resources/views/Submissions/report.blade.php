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
            <form method="get" action="{{ route('submissions.index') }}">
                <h2>Search Parameters</h2>
                <div class="row">
                    <label class="col-3">Form:
                        <select class="form-control text-reset" type="text" name='form'
                                aria-label="Search">
                            <option></option>
                            @foreach($links as $link)
                                <option @if ($form == $link->title) {{ 'selected' }} @endif>{{ $link->title }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="col-2">Site:
                        <select class="form-control text-reset" type="text" name='site'>
                            <option @if ($site == "") {{ 'selected' }} @endif></option>
                            @foreach($sites as $_site)
                                <option @if($site == $_site->site) {{ 'selected' }} @endif>{{ $_site->site}}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="col-2">User:
                        <input class="form-control" type="text" placeholder="Search" name='user'
                               value="{{ $user ?? ""}}"
                               aria-label="Search"/>
                    </label>
                    <label class="col-3">Date Submitted From:
                        <input class="form-control text-reset" type="date" placeholder="Search" name='date_from'
                               value="{{ $date_from ?? "" }}"
                               aria-label="Search"/>
                    </label>
                    <label class="col-2">Date Submitted To:
                        <input class="form-control text-reset" type="date" placeholder="Search" name='date_to'
                               value="{{ $date_to ?? "" }}"
                               aria-label="Search"/>
                    </label>
                </div>

                <div class="row container">
                    <div class="col-4">
                        <button class="btn btn-primary w-100" type="submit">Search</button>
                    </div>
                    <div class="col-4">
                        <button class="btn btn-dark w-100" type="button" id="clear">Clear Search Fields</button>
                    </div>

                    @if($form)
                        <div class="col-4">
                            <a href="{{ route('submissions.export', ['form'=>$form, 'user'=>$user, 'site'=>$site, 'date_from'=>$date_from, 'date_to'=>$date_to]) }}"
                              class="btn btn-success w-100">Export</a>
                        </div>
                    @endif
                </div>
            </form>

        </article>
        <table id="users" class="table table-bordered table-hover">
            <tr>
                <th>Form</th>
                <th>School/Site</th>
                <th>User</th>
                <th>Date Submitted</th>
                <th>View</th>
                @if(Auth::user()->isAdmin())
                    <th></th>@endif
            </tr>

            @foreach($submissions as $submission)
                <tr class="row-data">
                    <td>{{ $submission->forms->title }}</td>
                    <td>{{ $submission->site }}</td>
                    <td>{{ $submission->users->name }}</td>
                    <td>{{ App\Helpers\Helper::makeDateReadable($submission->created_at) }}</td>
                    <td><a href="{{ route('submissions.show', ['submission' => $submission]) }}">View</a></td>
                    @if($admin)
                        <td>
                            <form method="post" class="delete_form"
                                  action="{{route('submissions.destroy', $submission->id)}}">
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
                {{ $submissions->appends(['form'=>$form, 'user'=>$user, 'site'=>$site, 'date_from'=>$date_from, 'date_to'=>$date_to])->links() }}
            </div>
    </div>

@endsection
