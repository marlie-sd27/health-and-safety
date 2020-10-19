@extends('layout')

@section('content')
    <h1>My Profile</h1>
    <table>
        <tr>
            <th>Name</th>
            <td>{{ $userName }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $userEmail }}</td>
        </tr>
        <tr>
            <th>Site Admin</th>
            <td>{{ $admin ? 'true' : 'false' }}</td>
        </tr>
        <tr>
            <th>(Vice) Principal</th>
            <td>{{ $principal ? 'true' : 'false' }}</td>
        </tr>
        <tr>
            <th>Reporting Access</th>
            <td>{{ $report_access ? 'true' : 'false' }}</td>
        </tr>
        <tr>
            <th>Department</th>
            <td>{{ Auth::user()->department }}</td>
        </tr>
        <tr>
            <th>Job Title</th>
            <td>{{ Auth::user()->position }}</td>
        </tr>
    </table>
@endsection
