@extends('layout')

@section('content')
    <a href="{{ url()->previous() }}">Back</a>
    @isset($outstanding)<p class="d-none" id="outstanding">{{ $outstanding }}</p>@endisset
    @isset($emails)<p class="d-none" id="emails">{{ $emails }}</p>@endisset
    <div class="container">
        <h1>{{ $event->forms->title ?? ''}}</h1>
        @isset($event)<h2>Due {{ $event ? date('M d, Y', strtotime($event->date)) : ''}}</h2>@endisset
        <h2>{{ $site ?? '' }}</h2>

        <article class="row" id="create">
            <h3>Select Site, Form and Deadline to report on</h3>
            <form action="{{ route('report.bysite') }}" method="get">
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
                            <option @if ($form == $link->title) {{ 'selected' }} @endif >{{ $link->title }}</option>
                        @endforeach
                    </select>
                </label>
                <label><span class="required">*</span> Select Deadline:
                    <input class="form-control" type="date" name='deadline'
                           value="{{ $deadline ?? ""}}"
                           aria-label="Search"
                           required/>
                </label>
                <button class="btn btn-primary" type="submit">Report</button>
            </form>
        </article>
        <div class="row ">
            @isset($emails)
                <article>
                    <p class="text-center">Copy all emails to Clipboard</p>
                    <button class="btn btn-secondary text-center" type="button" value="copy"
                            onclick="copyToClipboard('#emails')">Copy!
                    </button>
                </article>
            @endisset
            @isset($outstanding)
                <article>
                    <p class="text-center">Copy emails with outstanding submissions to Clipboard</p>
                    <button class="btn btn-secondary text-center" type="button" value="copy"
                            onclick="copyToClipboard('#outstanding')">Copy!
                    </button>
                </article>
            @endisset
            <div class="col-md-12">
                <table class="table table-bordered table-hover container">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Site</th>
                        <th>Complete</th>
                        <th>View</th>
                    </tr>
                    @isset($users)
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->getDisplayName() }}</td>
                                <td>{{ $user->getMail() }}</td>
                                <td>{{ $user->getDepartment() }}</td>
                                <td>{{ $submissions->has($user->getMail()) ? 'Complete' : '' }}</td>
                                <td>@if($submissions->has($user->getMail()))
                                        <a href="{{ route('submissions.show', ['submission' => $submissions->get($user->getMail())]) }}">View</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endisset
                </table>
            </div>

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
