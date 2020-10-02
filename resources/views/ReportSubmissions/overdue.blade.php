@extends('layout')

@section('content')
    <a href="{{ url()->previous() }}">Back</a>
    <div class="container">
    <h1>Overdue Submissions</h1>
        <article class="container">
            <form method="get" action="{{ route('submissions.overdue') }}">
                <label>Search by form:
                    <select class="form-control text-reset" type="text" name='form'
                            aria-label="Search">
                        <option></option>
                        @foreach($links as $link)
                            <option @if ($form == $link->title) {{ 'selected' }} @endif>{{ $link->title }}</option>
                        @endforeach
                    </select>
                </label>
                <label>Search by user:
                    <input class="form-control" type="text" placeholder="Search" name='user'
                           value="{{ $user ?? ""}}"
                           aria-label="Search"/>
                </label>
                <label>Search from date:
                    <input class="form-control text-reset" type="date" placeholder="Search" name='date_from'
                           value="{{ $date_from ?? "" }}"
                           aria-label="Search"/>
                </label>
                <label>to date:
                    <input class="form-control text-reset" type="date" placeholder="Search" name='date_to'
                           value="{{ $date_to ?? "" }}"
                           aria-label="Search"/>
                </label>

                <button class="btn btn-primary" type="submit">Search</button>
                <button class="btn btn-dark" type="button" id="clear">Clear Search Fields</button>
            </form>
        </article>
        <table class="table table-bordered table-hover">
            <tr>
                <th>Form</th>
                <th>User</th>
                <th>Due</th>
            </tr>
            @foreach( $overdues as $user => $overdue)
                @foreach($overdue as $key => $value)
                    <tr>
                        <td>
                            <a href="{{ route('forms.show', ['form' => $value->forms_id, 'event' => $value->id]) }}">{{ $value->title }}</a>
                        </td>
                        <td>{{ $user }}</td>
                        <td>{{ \App\Helpers\Helper::makeDateReadable($value->date) }}</td>
                    </tr>
                @endforeach
            @endforeach
        </table>
    </div>
@endsection
