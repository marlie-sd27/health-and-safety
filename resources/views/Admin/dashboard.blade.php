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
                    @foreach( $overdues as $user => $overdue)
                        @foreach($overdue as $key => $value)
                            <tr>
                                <td>
                                    <a href="{{ route('forms.show', ['form' => $value->forms_id, 'event' => $value->id]) }}">{{ $value->title }}</a>
                                </td>
                                <td>{{ $user }}</td>
                                <td>{{ \App\Helpers\Helper::makeDateReadable($value->date) }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </table>
                <a class="text-right" href="{{ route('submissions.overdue') }}">See all overdues...</a>
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
                <a class="text-right" href="{{ route('submissions.upcoming') }}">See all upcoming...</a>
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
                <a class="text-right" href="{{ route('submissions.report') }}">See all submissions...</a>
            </div>
        </div>
    </div>
@endsection
