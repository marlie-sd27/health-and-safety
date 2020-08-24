@extends('layout')

@section('content')
    @if(Auth::user()->isAdmin())
        <div class="container">
            <a href="{{ route('events') }}">List all event deadlines..</a>
        </div>
    @endif
    @if(!Auth::user()->isPrincipal())
        <div class="alert alert-danger alert-dismissible alert-dismissible fade show" role="alert">
            <p>Currently, teachers are not able to view calendar events. This is a known issue and we are
                working on resolving it as soon as possible. Thank you for your patience. In the meantime, you can still
                view upcoming deadlines from your dashboard</p>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div id="calendar"></div>
@endsection
