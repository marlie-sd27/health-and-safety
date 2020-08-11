@extends('layout')

@section('content')
    <a href="{{ url()->previous() }}">Back</a>
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
@endsection
