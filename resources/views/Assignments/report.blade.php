@extends('layout')

@section('content')
    <a href="{{ url()->previous() }}">Back</a>

    <article class="container">
        <form method="get" action="{{ route('assignments.report') }}">
            <h2>Search Filters</h2>
            <div class="row">
                <label class="col-4">Form:
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
                <label class="col-4">Site:
                    <select class="form-control text-reset" type="text" name='site'>
                        <option @if ($site == "") {{ 'selected' }} @endif></option>
                        @foreach($sites as $_site)
                            <option @if($site == $_site->site) {{ 'selected' }} @endif>{{ $_site->site}}</option>
                        @endforeach
                    </select>
                </label>
                <label class="col-4">Group:
                    <select class="form-control text-reset" type="text" name='group'>
                        <option @if ($group == "") {{ 'selected' }} @endif></option>
                        @foreach($groups as $_group)
                            <option @if($group == $_group->name) {{ 'selected' }} @endif>{{ $_group->name}}</option>
                        @endforeach
                    </select>
                </label>
            </div>
            <div class="row">
                <label class="col-4">Staff Member:
                    <input class="form-control" type="text" placeholder="Search" name='user'
                           value="{{ $user ?? ""}}"
                           aria-label="Search"/>
                </label>
                <label class="col-4">Due Date From:
                    <input class="form-control text-reset" type="date" placeholder="Search" name='date_from'
                           value="{{ $date_from ?? "" }}"
                           aria-label="Search"/>
                </label>
                <label class="col-4">Due Date To:
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
                    <th>Staff/Site</th>
                    <th>Form</th>
                    <th>Due</th>
                </tr>
                @isset($overdues)
                    @foreach($overdues as $overdue)
                        <tr>
                            <td>{{ $overdue->site ?? str_replace(['@sd27.bc.ca','.'], ' ', $overdue->email) }}</td>
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
                    <th>Staff/Site</th>
                    <th>Form</th>
                    <th>Due</th>
                </tr>
                @isset($completeds)
                    @foreach($completeds as $completed)

                        <tr>
                            <td>{{ $completed->site ?? str_replace(['@sd27.bc.ca','.'], ' ', $completed->email) }}</td>
                            <td>
                                <a href="{{ route('submissions.show', ['submission' => $completed->id]) }}">{{ $completed->title }}</a>
                            </td>
                            <td>{{ \App\Helpers\Helper::makeDateReadable($completed->date) }}</td>
                        </tr>
                        </a>
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
