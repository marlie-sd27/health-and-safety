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
                @include('Reusable/searchFiltersAdmin', ['prefix' => 'Submitted By'])

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
