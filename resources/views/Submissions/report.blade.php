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
                <h2>Search Filters</h2>
                <div class="row">
                    <label class="col-4">Form:
                        <select class="form-control text-reset"
                                type="text"
                                name='form'
                                aria-label="Search">
                            <option></option>
                            @foreach($links as $link)
                                <option @if ($form == $link->title) {{ 'selected' }} @endif>{{ $link->title }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="col-4">Staff members at Site:
                        <select class="form-control text-reset" type="text" name='site_staff'>
                            <option @if ($site_staff == "") {{ 'selected' }} @endif></option>
                            @foreach($sites as $_site)
                                <option value="{{ $_site->id }}" @if($site_staff == $_site->id) {{ 'selected' }} @endif>{{ $_site->site}}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="col-4">Staff members at Group:
                        <select class="form-control text-reset" type="text" name='group'>
                            <option @if ($group == "") {{ 'selected' }} @endif></option>
                            @foreach($groups as $_group)
                                <option value="{{ $_group->id }}" @if($group == $_group->id) {{ 'selected' }} @endif>{{ $_group->name}}</option>
                            @endforeach
                        </select>
                    </label>
                </div>
                <div class="row">
                    <label class="col-3">Submitted by Staff Member:
                        <input class="form-control" type="text" name='user'
                               value="{{ $user ?? ""}}"
                               aria-label="Search"/>
                    </label>
                    <label class="col-3">Submitted for Site:
                        <select class="form-control text-reset" type="text" name='site_due'>
                            <option @if ($site_due == "") {{ 'selected' }} @endif></option>
                            @foreach($sites as $_site)
                                <option value="{{ $_site->id }}" @if($site_due == $_site->id) {{ 'selected' }} @endif>{{ $_site->site}}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="col-3">Submitted Date Ranging From:
                        <input class="form-control text-reset" type="date" placeholder="Search" name='date_from'
                               value="{{ $date_from ?? "" }}"
                               aria-label="Search"/>
                    </label>
                    <label class="col-3">Submitted Date Ranging To:
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
                            <a href="{{ route('submissions.export', ['form'=>$form, 'user'=>$user, 'site_due'=>$site_due, 'site_staff'=>$site_staff, 'group' => $group, 'date_from'=>$date_from, 'date_to'=>$date_to]) }}"
                              class="btn btn-success w-100">Export</a>
                        </div>
                    @endif
                </div>
            </form>

        </article>
        <table id="users" class="table table-bordered table-hover">
            <tr>
                <th>Form</th>
                <th>Staff</th>
                <th>Site</th>
                <th>Date Submitted</th>
                <th>View</th>
                @if(Auth::user()->isAdmin())
                    <th></th>@endif
            </tr>

            @foreach($submissions as $submission)
                <tr class="row-data">
                    <td>{{ $submission->forms->title }}</td>
                    <td>{{ str_replace(['@sd27.bc.ca','.'], ' ', $submission->email) }}</td>
                    <td>{{ $submission->sites->site ?? '' }}</td>
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
                {{ $submissions->withQueryString()->links() }}
            </div>
    </div>

@endsection
