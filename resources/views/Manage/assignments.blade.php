@extends('layout')

@section('content')

    <a href="{{ url()->previous() }}">Back</a>
    <div class="container">
        <h1>Assignments</h1>
        <p>These are all the assignments for users or sites to complete form submissions by a certain deadline.</p>
        <div class="row">
            <article class="container">
                <form method="get" action="{{ route('assignments') }}">
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
                                    <option
                                        value="{{ $_site->id }}" @if($site_staff == $_site->id) {{ 'selected' }} @endif>{{ $_site->site}}</option>
                                @endforeach
                            </select>
                        </label>
                        <label class="col-4">Staff members in Group:
                            <select class="form-control text-reset" type="text" name='group'>
                                <option @if ($group == "") {{ 'selected' }} @endif></option>
                                @foreach($groups as $_group)
                                    <option
                                        value="{{ $_group->id }}" @if($group == $_group->id) {{ 'selected' }} @endif>{{ $_group->name}}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>
                    <div class="row">
                        <label class="col-3">Due for Staff Member:
                            <input class="form-control" type="text" name='user'
                                   value="{{ $user ?? ""}}"
                                   aria-label="Search"/>
                        </label>
                        <label class="col-3">Due for Site:
                            <select class="form-control text-reset" type="text" name='site_due'>
                                <option @if ($site_due == "") {{ 'selected' }} @endif></option>
                                @foreach($sites as $_site)
                                    <option
                                        value="{{ $_site->id }}" @if($site_due == $_site->id) {{ 'selected' }} @endif>{{ $_site->site}}</option>
                                @endforeach
                            </select>
                        </label>
                        <label class="col-3">Due Date Ranging From:
                            <input class="form-control text-reset" type="date" placeholder="Search" name='date_from'
                                   value="{{ $date_from ?? "" }}"
                                   aria-label="Search"/>
                        </label>
                        <label class="col-3">Due Date Ranging To:
                            <input class="form-control text-reset" type="date" placeholder="Search" name='date_to'
                                   value="{{ $date_to ?? "" }}"
                                   aria-label="Search"/>
                        </label>
                    </div>
                    <div class="row container">
                        <div class="col-6">
                            <button class="btn btn-primary w-100" type="submit">Search <i class="fas fa-search"></i></button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-dark w-100" type="button" id="clear">Clear Search Fields</button>
                        </div>
                    </div>
                </form>
            </article>
            <table class="table table-bordered table-hover container">
                <tr>
                    <th>Due For</th>
                    <th>Due</th>
                    <th>Form</th>
                    <th>Delete</th>
                </tr>
                @foreach($assignments as $assignment)
                    <tr>
                        <td>{{ $assignment->sites->site ?? str_replace(['@sd27.bc.ca','.'], ' ', $assignment->email) }}</td>
                        <td>{{ $assignment->events ? \App\Helpers\Helper::makeDateReadable($assignment->events->date) : '' }}</td>
                        <td>{{ $assignment->events->forms->title ?? '' }}</td>
                        <td>
                            <form method="post"
                                  class="delete_form float-right"
                                  action="{{route('assignments.destroy', $assignment->id, ['form'=>$form, 'user'=>$user, 'site_due'=>$site_due, 'site_staff'=>$site_staff, 'group' => $group, 'date_from'=>$date_from, 'date_to'=>$date_to])}}">
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
        </div>
        <p>{{ $assignments->withQueryString()->links() }}</p>
    </div>

@endsection
