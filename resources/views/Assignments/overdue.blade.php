@extends('layout')

@section('content')
    <a href="{{ url()->previous() }}">Back</a>
    @isset($emails)<p class="d-none" id="emails">{{ $emails }}</p>@endisset
    <div class="container">
        <article class="container">
            <form method="get" action="{{ route('assignments.overdue') }}">
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
                    <label class="col-4">Staff members at Site:
                        <select class="form-control text-reset" type="text" name='site_staff'>
                            <option @if ($site_staff == "") {{ 'selected' }} @endif></option>
                            @foreach($sites as $_site)
                                <option
                                    value="{{ $_site->id }}" @if($site_staff == $_site->id) {{ 'selected' }} @endif>{{ $_site->site}}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="col-4">Staff members in Group:
                        <select class="form-control text-reset" type="text" name='group'>
                            <option @if ($group == "") {{ 'selected' }} @endif></option>
                            @foreach($groups as $_group)
                                <option
                                    value="{{ $_group->id }}" @if($group == $_group->id) {{ 'selected' }} @endif>{{ $_group->name}}</option>
                            @endforeach
                        </select>
                    </label>
                </div>
                <div class="row">
                    <label class="col-3">Due for Staff Member:
                        <input class="form-control" type="text" name='user'
                               value="{{ $user ?? ""}}"
                               aria-label="Search"/>
                    </label>
                    <label class="col-3">Due for Site:
                        <select class="form-control text-reset" type="text" name='site_due'>
                            <option @if ($site_due == "") {{ 'selected' }} @endif></option>
                            @foreach($sites as $_site)
                                <option
                                    value="{{ $_site->id }}" @if($site_due == $_site->id) {{ 'selected' }} @endif>{{ $_site->site}}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="col-3">Due Date Ranging From:
                        <input class="form-control text-reset" type="date" placeholder="Search" name='date_from'
                               value="{{ $date_from ?? "" }}"
                               aria-label="Search"/>
                    </label>
                    <label class="col-3">Due Date Ranging To:
                        <input class="form-control text-reset" type="date" placeholder="Search" name='date_to'
                               value="{{ $date_to ?? "" }}"
                               aria-label="Search"/>
                    </label>
                </div>
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
