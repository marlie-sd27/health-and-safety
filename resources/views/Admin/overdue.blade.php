@extends('layout')

@section('content')
    <a href="{{ url()->previous() }}">Back</a>
    <h1>Overdue Submissions</h1>
    <div class="container">
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
    </div>
@endsection
