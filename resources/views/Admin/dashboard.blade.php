@extends('layout')

@section('content')
    <h1>{{ $userName }}'s Dashboard</h1>
    <div class="container">
        <div class="row">
            <div class="col-lg card">
                <h2>Overdue</h2>
                <table class="table table-bordered table-hover">
                    <tr>
                        <th>Form</th>
                        <th>User</th>
                        <th>Due</th>
                    </tr>
                    @foreach( $overdues as $overdue)
                        <tr>
                            <td>
                                <a href="{{ route('forms.show', ['form' => $overdue->forms_id, 'event' => $overdue->id]) }}">{{ $overdue->forms->title }}</a>
                            </td>
                            <td>{{ $overdue->site ?? str_replace(['@sd27.bc.ca','.'], ' ', $overdue->email) }}</td>
                            <td>{{ \App\Helpers\Helper::makeDateReadable($overdue->date) }}</td>
                        </tr>
                    @endforeach
                </table>
                <a class="text-right" href="{{ route('assignments.overdue') }}">See all overdues...</a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg card">
                <h2>Upcoming Deadlines</h2>
                <table class="table table-bordered table-hover">
                    <tr>
                        <th>Form</th>
                        <th>Required For</th>
                        <th>Due</th>
                    </tr>
                    @foreach( $upcomings as $upcoming)
                        <tr>
                            <td>
                                <a href="{{ route('forms.show', ['form' => $upcoming->forms->id, 'event' => $upcoming->id]) }}">{{ $upcoming->forms->title }}</a>
                            </td>
                            <td>{{ $upcoming->forms->required_for }}</td>
                            <td>{{ \App\Helpers\Helper::makeDateReadable($upcoming->date) }}</td>
                        </tr>
                    @endforeach
                </table>
                <a class="text-right" href="{{ route('calendar') }}">See all upcoming...</a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg card">
                <h2>Recent Submissions</h2>
                <table class="table table-bordered table-hover">
                    <tr>
                        <th>User</th>
                        <th>Site</th>
                        <th>Form</th>
                        <th>Due</th>
                        <th>Submitted</th>
                        <th>View</th>
                    </tr>
                    @foreach( $recents as $recent)
                        <tr>
                            <td>{{ str_replace(['@sd27.bc.ca','.'], ' ', $recent->email) }}</td>
                            <td>{{ $recent->sites->site }}</td>
                            <td>{{ $recent->forms->title }}</td>
                            @if(isset($recent->events->date))
                                <td>{{ \App\Helpers\Helper::makeDateReadable($recent->events->date) }}</td>
                            @else
                                <td>N/A</td>
                            @endif
                            @if(isset($recent->created_at))
                                <td>{{ \App\Helpers\Helper::makeDateReadable($recent->created_at) }}</td>
                            @else
                                <td>N/A</td>
                            @endif
                            <td>
                                <a href="{{ route('submissions.show', ['submission' => $recent->id]) }}">View</a>
                            </td>
                        </tr>
                    @endforeach
                </table>
                <a class="text-right" href="{{ route('submissions.index') }}">See all submissions...</a>
            </div>
        </div>
    </div>
@endsection
