@extends('layout')

@section('content')
    <h1>Event Deadlines</h1>

    <table class="table table-bordered table-hover">
        <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Form</th>
            <th>Required For</th>
            <th>Delete</th>
        </tr>
        @foreach($events as $event)
            <tr>
                <td><small>{{ $event->id}}</small></td>
                <td>{{ \App\Helpers\Helper::makeDateReadable($event->date) }}</td>
                <td>{{ $event->forms->title }}</td>
                <td>{{ $event->forms->required_for }}</td>
                <td>
                    <form method="post" class="delete_form"
                          action="{{route('events.destroy', $event->id)}}">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-secondary" onclick="return confirm('Are you sure?')">
                            Remove Event
                        </button>
                    </form>
                </td>
            </tr>

        @endforeach
    </table>
    <div>
        {{ $events->links() }}
    </div>
@endsection
