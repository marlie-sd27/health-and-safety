@extends('layout')

@section('content')
    <a href="{{ url()->previous() }}">Back</a>

    <article class="container">
        <form method="get" action="{{ route('assignments.report') }}">
{{--            @if($admin)--}}
                @include('Reusable/searchFiltersAdmin', ['prefix' => 'Due for'])
{{--            @else--}}
{{--                @include('Reusable/searchFiltersPrincipal')--}}
{{--            @endif--}}
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
