@extends('layout')

@section('content')
    <a href="{{ url()->previous() }}">Back</a>
    <div class="container">
        <h1>{{ $event->forms->title }}</h1>
        <h2>Due {{ date('M d, Y', strtotime($event->date)) }}</h2>
        <h2>Nesika</h2>


        <div class="row">
            <table class="table table-bordered table-hover container">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Site</th>
                    <th>Job Title</th>
                    <th>Complete</th>
                </tr>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->getDisplayName() }}</td>
                        <td>{{ $user->getMail() }}</td>
                        <td>{{ $user->getDepartment() }}</td>
                        <td>{{ $user->getJobTitle() }}</td>
                        <td>{{ $submissions->contains($user->getMail()) ? 'Complete' : '' }}</td>
                    </tr>
                @endforeach
            </table>
        </div>

        @if($next)
            <a href="{{ route('retrieve', ['next' => $next]) }}">Next Page</a>
        @endif


    </div>

@endsection
