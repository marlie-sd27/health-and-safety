@extends('layout')

@section('content')
    <h1>{{ $userName }}'s Dashboard</h1>
    <div class="container">
        <div class="row">
            <div class="col-md card">
                <h2>Overdue</h2>
                <table class="table table-bordered table-hover">
                    @foreach( $overdues as $overdue)
                        <tr>
                            <td><a href="{{ route('forms.show', ['form' => $overdue->forms->id, 'event' => $overdue->id]) }}">{{ $overdue->forms->title }}</a></td>
                            <td>{{ \App\Helpers\Helper::makeDateReadable($overdue->date) }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <div class="col-md card">
                <h2>Upcomings</h2>
                <table class="table table-bordered table-hover">
                    @foreach( $upcomings as $upcoming)
                        <tr>
                            <td><a href="{{ route('forms.show', ['form' => $upcoming->forms->id, 'event' => $upcoming->id]) }}">{{ $upcoming->forms->title }}</a></td>
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
                        <th>View</th>
                    </tr>
                    @foreach( $completeds as $completed)

                        <tr>
                            <td>{{ $completed->forms->title }}</td>
                            <td>{{ \App\Helpers\Helper::makeDateReadable($completed->events->date) }}</td>
                            <td>{{ \App\Helpers\Helper::makeDateReadable($completed->created_at) }}</td>
                            <td><a href="{{ route('submissions.show', ['submission' => $completed->id]) }}">View Submission</a></td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
