@extends('layout')

@section('content')
    @if($principal)
    <div class="alert alert-info alert-dismissible alert-dismissible fade show" role="alert">
        There have been many updates/changes to the Health & Safety Dashboard. Please report any bugs you may encounter
        to marlie.dueck@sd27.bc.ca. The "Help/Tutorials" section will contain useful information on how to use the new
        searching and reporting interfaces and will be available soon. Please be patient while it's under
        construction. Thank you!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    <h1>{{ $userName }}'s Dashboard</h1>
    <div class="container">
        <div class="row">
            <div class="col-md card">
                <h2>Overdue</h2>
                <table class="table table-bordered table-hover">
                    @foreach( $overdues as $overdue)
                        <tr>
                            <td>
                                <a href="{{ route('forms.show', ['form' => $overdue->forms->id, 'event' => $overdue->id]) }}">{{ $overdue->forms->title }}</a>
                            </td>
                            <td>{{ \App\Helpers\Helper::makeDateReadable($overdue->date) }}</td>
                        </tr>
                    @endforeach
                    @if(sizeof($overdues) == 0)
                        <h3 class="text-center container">You have no overdue deadlines!</h3>
                    @endif
                </table>
            </div>
            <div class="col-md card">
                <h2>Upcomings</h2>
                <table class="table table-bordered table-hover">
                    @foreach( $upcomings as $upcoming)
                        <tr>
                            <td>
                                <a href="{{ route('forms.show', ['form' => $upcoming->forms->id, 'event' => $upcoming->id]) }}">{{ $upcoming->forms->title }}</a>
                            </td>
                            <td>{{ \App\Helpers\Helper::makeDateReadable($upcoming->date) }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-lg card">
                <h2>Recently Completed</h2>
                <table class="table table-bordered table-hover">
                    <tr>
                        <th>Form</th>
                        <th>Due</th>
                        <th>Submitted</th>
                        @if($principal)
                            <th>Submitter</th>
                        @endif
                        <th>View</th>
                    </tr>
                    @foreach( $completeds as $completed)

                        <tr>
                            <td>{{ $completed->forms->title }}</td>
                            @if(isset($completed->events->date))
                                <td>{{ \App\Helpers\Helper::makeDateReadable($completed->events->date) }}</td>
                            @else
                                <td>N/A</td>
                            @endif
                            <td>{{ \App\Helpers\Helper::makeDateReadable($completed->created_at) }}</td>
                            @if($principal)
                                <td>{{ str_replace(['@sd27.bc.ca','.'], ' ', $completed->email) }}</td>
                            @endif
                            <td><a href="{{ route('submissions.show', ['submission' => $completed->id]) }}">View</a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
