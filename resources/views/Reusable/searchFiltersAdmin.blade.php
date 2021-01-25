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
    <label class="col-4">Staff members by Group:
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
    <label class="col-3">{{ $prefix }} Staff Member:
        <input class="form-control" type="text" name='user'
               value="{{ $user ?? ""}}"
               aria-label="Search"/>
    </label>
    <label class="col-3">{{ $prefix }} Site:
        <select class="form-control text-reset" type="text" name='site_due'>
            <option @if ($site_due == "") {{ 'selected' }} @endif></option>
            @foreach($sites as $_site)
                <option
                    value="{{ $_site->id }}" @if($site_due == $_site->id) {{ 'selected' }} @endif>{{ $_site->site}}</option>
            @endforeach
        </select>
    </label>
    <label class="col-3">Date Ranging From:
        <input class="form-control text-reset" type="date" placeholder="Search" name='date_from'
               value="{{ $date_from ?? "" }}"
               aria-label="Search"/>
    </label>
    <label class="col-3">Date Ranging To:
        <input class="form-control text-reset" type="date" placeholder="Search" name='date_to'
               value="{{ $date_to ?? "" }}"
               aria-label="Search"/>
    </label>
</div>
