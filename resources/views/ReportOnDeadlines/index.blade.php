@extends('layout')

@section('content')
    <a href="{{ url()->previous() }}">Back</a>
    <div class="container">
        <h1>{{ $event->forms->title ?? ''}}</h1>
        @isset($event)<h2>Due {{ $event ? date('M d, Y', strtotime($event->date)) : ''}}</h2>@endisset
        <h2>{{ $site ?? '' }}</h2>

        <article class="row" id="create">
            <h3>Select Site, Form and Deadline to report on</h3>
            <form action="{{ route('report-deadlines') }}" method="get">
                @csrf
                <label><span class="required">*</span>Select Site:
                    <select class="form-control text-reset" type="text" name='site' required>
                        <option @if ($site == "") {{ 'selected' }} @endif></option>
                        @foreach($sites as $_site)
                            <option @if($site == $_site->site) {{ 'selected' }} @endif>{{ $_site->site}}</option>
                        @endforeach
                    </select>
                </label>
                <label><span class="required">*</span>Select Form:
                    <select class="form-control text-reset"
                            type="text"
                            name='form'
                            aria-label="Search"
                            required>
                        <option></option>
                    @foreach($links as $link)
                            <option @isset($form)@if ($form->title == $link->title) {{ 'selected' }} @endif @endisset>{{ $link->title }}</option>
                        @endforeach
                    </select>
                </label>
                <label><span class="required">*</span> Select Deadline:
                    <input class="form-control" type="date" name='deadline'
                           value="{{ $deadline ?? ""}}"
                           aria-label="Search"
                           required/>
                </label>
                <button class="btn btn-primary">Report</button>
            </form>
        </article>
        <div class="row ">

            <div class="col-md-12">
                <table class="table table-bordered table-hover container">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Site</th>
                        <th>Complete</th>
                    </tr>
                    @isset($users)
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->getDisplayName() }}</td>
                                <td>{{ $user->getMail() }}</td>
                                <td>{{ $user->getDepartment() }}</td>
                                <td>{{ $submissions->contains($user->getMail()) ? 'Complete' : '' }}</td>
                            </tr>
                        @endforeach
                    @endisset
                </table>
            </div>

        </div>

    </div>

@endsection
