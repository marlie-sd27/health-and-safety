@extends('layout')

@section('content')
    <a href="{{ url()->previous() }}">Back</a>
    @isset($emails)<p class="d-none" id="emails">{{ $emails }}</p>@endisset
    <div class="container">
        <article class="container">
            <form method="get" action="{{ route('assignments.overdue') }}">
                @include('Reusable/searchFiltersAdmin', ['prefix' => 'Due For'])
                <div class="row container">
                    <div class="col-4">
                        <button class="btn btn-primary w-100" type="submit">Search <i class="fas fa-search"></i></button>
                    </div>
                    <div class="col-4">
                        <button class="btn btn-dark w-100" type="button" id="clear">Clear Search Fields</button>
                    </div>
                    @isset($emails)
                        <div class="col-4">
                            <button class="btn btn-success w-100" type="button" value="copy" id="copy-emails"
                                    onclick="copyToClipboard('#emails')">Copy Emails <i class="far fa-copy"></i>
                            </button>
                        </div>
                    @endisset
                </div>
            </form>
        </article>
        <table class="table table-bordered table-hover">
            <tr>
                <th>Form</th>
                <th>Staff/Site</th>
                <th>Due</th>
            </tr>
            @foreach( $overdues as $overdue)
                <tr>
                    <td>
                        <a href="{{ route('forms.show', ['form' => $overdue->forms_id, 'event' => $overdue->id]) }}">{{ $overdue->forms->title }}</a>
                    </td>
                    <td>{{ $overdue->site ?? str_replace(['@sd27.bc.ca','.'], ' ', $overdue->email) }}</td>
                    <td>{{ \App\Helpers\Helper::makeDateReadable($overdue->date) }}</td>
                </tr>
            @endforeach
        </table>
        <p class="text-center">{{ $overdues->withQueryString()->links() }}</p>
    </div>

    <script type="text/javascript">
        function copyToClipboard(element) {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(element).text()).select();
            document.execCommand("copy");
            $temp.remove();
            $('#copy-emails').html('Copied!');
        }
    </script>
@endsection
