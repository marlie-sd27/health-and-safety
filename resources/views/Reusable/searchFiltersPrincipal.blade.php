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
    <label class="col-3">Staff Member:
        <input class="form-control" type="text" name='user'
               value="{{ $user ?? ""}}"
               aria-label="Search"/>
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
