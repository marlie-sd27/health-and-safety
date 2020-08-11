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
                                <a href="{{ route('forms.show', ['form' => $overdue->forms->id, 'event' => $overdue->id]) }}">{{ $overdue->forms->title }}</a>
                            </td>
                            <td>{{ Auth::user()->name }}</td>
                            <td>{{ \App\Helpers\Helper::makeDateReadable($overdue->date) }}</td>
                        </tr>
                    @endforeach
                </table>
                <a class="text-right" href="{{ route('report.overdue') }}">See all overdues...</a>
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
                <a class="text-right" href="{{ route('report.upcoming') }}">See all upcoming...</a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg card">
                <h2>Recent Submissions</h2>
                <table class="table table-bordered table-hover">
                    @foreach( $recents as $recent)
                        <tr>
                            <td>{{ $recent->users->name }}</td>
                            <td>{{ $recent->forms->title }}</td>
                            @if(isset($recent->created_at))
                                <td>{{ \App\Helpers\Helper::makeDateReadable($recent->created_at) }}</td>
                            @else
                                <td>N/A</td>
                            @endif
                            <td><a href="{{ route('submissions.show', ['submission' => $recent->id]) }}">View
                                    Submission</a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
