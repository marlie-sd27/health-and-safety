@extends('layout')

@section('content')
    <a href="{{ url()->previous() }}">Back</a>

    <article class="container">
        <form method="get" action="{{ route('assignments.report') }}">
            <h2>Search Filters</h2>
            <div class="row">
                <label class="col-3">Form:
                    <select class="form-control text-reset"
                            type="text"
                            name='form'
                            aria-label="Search">
                        <option></option>
                        @foreach($links as $link)
                            <option @if ($form == $link->title) {{ 'selected' }} @endif>{{ $link->title }}</option>
                        @endforeach
                    </select>
                </label>
                <label class="col-3">Site:
                    <select class="form-control text-reset" type="text" name='site'>
                        <option @if ($site == "") {{ 'selected' }} @endif></option>
                        @foreach($sites as $_site)
                            <option @if($site == $_site->site) {{ 'selected' }} @endif>{{ $_site->site}}</option>
                        @endforeach
                    </select>
                </label>
                <label class="col-2">User:
                    <input class="form-control" type="text" placeholder="Search" name='user'
                           value="{{ $user ?? ""}}"
                           aria-label="Search"/>
                </label>
                <label class="col-2">Due Date From:
                    <input class="form-control text-reset" type="date" placeholder="Search" name='date_from'
                           value="{{ $date_from ?? "" }}"
                           aria-label="Search"/>
                </label>
                <label class="col-2">Due Date To:
                    <input class="form-control text-reset" type="date" placeholder="Search" name='date_to'
                           value="{{ $date_to ?? "" }}"
                           aria-label="Search"/>
                </label>
            </div>
            <div class="row container">
                <div class="col-6">
                    <button class="btn btn-primary w-100" type="submit">Search</button>
                </div>
                <div class="col-6">
                    <button class="btn btn-dark w-100" type="button" id="clear">Clear Search Fields</button>
                </div>
            </div>
        </form>
    </article>
    <div class="row ">
        <div class="col-md-6">
            <h2>Overdue</h2>
            <table class="table table-bordered table-hover">
                <tr>
                    <th>User</th>
                    <th>Form</th>
                    <th>Due</th>
                </tr>
                @isset($overdues)
                    @foreach($overdues as $overdue)
                        <tr>
                            <td>{{ str_replace(['@sd27.bc.ca','.'], ' ', $overdue->email) }}</td>
                            <td>{{ $overdue->title }}</td>
                            <td>{{ \App\Helpers\Helper::makeDateReadable($overdue->date) }}</td>
                        </tr>
                    @endforeach
                @endisset
            </table>
            <p>{{ $overdues->withQueryString()->appends(array_except(Request::query(), 'overdue'))->links() }}</p>
        </div>
        <div class="col-md-6">
            <h2>Completed</h2>
            <table class="table table-bordered table-hover">
                <tr>
                    <th>User</th>
                    <th>Form</th>
                    <th>Due</th>
                    <th>View</th>
                </tr>
                @isset($completeds)
                    @foreach($completeds as $completed)
                        <tr>
                            <td>{{ str_replace(['@sd27.bc.ca','.'], ' ', $completed->email) }}</td>
                            <td>{{ $completed->title }}</td>
                            <td>{{ \App\Helpers\Helper::makeDateReadable($completed->date) }}</td>
                            <td>
                                <a href="{{ route('submissions.show', ['submission' => $completed->id]) }}">View</a>
                            </td>
                        </tr>
                    @endforeach
                @endisset
            </table>
            <p>{{ $completeds->withQueryString()->appends(array_except(Request::query(), 'completed'))->links() }}</p>
        </div>
        <script type="text/javascript">
            function copyToClipboard(element) {
                var $temp = $("<input>");
                $("body").append($temp);
                $temp.val($(element).text()).select();
                document.execCommand("copy");
                $temp.remove();
            }
        </script>

    </div>

@endsection
