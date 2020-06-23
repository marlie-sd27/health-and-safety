@extends('layout')

@section('content')
    <h1>My Profile</h1>
    <p>{{ $userName }}</p>
    <p>{{ $userEmail }}</p>
    <p>{{ $userId }}</p>

@endsection
