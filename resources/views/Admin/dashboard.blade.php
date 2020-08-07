@extends('layout')

@section('content')
    <h1>{{ $userName }}'s Dashboard</h1>
    <div class="container">
        <div class="row">
            <div class="col-md card">
                <h2>Overdue</h2>
                <table class="table table-bordered table-hover">
                    @foreach( $overdues as $key => $value)
                        <tr>
                            <td>{{ $key }}</td>
                            <td>{{ $value }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <div class="col-md card">
                <h2>Upcoming Deadlines</h2>
                <table class="table table-bordered table-hover">
                    <tr>
                        <th>Form</th>
                        <th>Required For</th>
                        <th>Due</th>
                    </tr>
                    @foreach( $upcomings as $upcoming)
                        <tr>
                            <td><a href="{{ route('forms.show', ['form' => $upcoming->forms->id, 'event' => $upcoming->id]) }}">{{ $upcoming->forms->title }}</a></td>
                            <td>{{ $upcoming->forms->required_for }}</td>
                            <td>{{ \App\Helpers\Helper::makeDateReadable($upcoming->date) }}</td>
                        </tr>
                    @endforeach
                </table>
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
                            <td>{{ \App\Helpers\Helper::makeDateReadable($recent->created_at) }}</td>
                            <td><a href="{{ route('submissions.show', ['submission' => $recent->id]) }}">View Submission</a></td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
