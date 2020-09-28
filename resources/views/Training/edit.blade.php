@extends('layout')

@section('content')

    <a href="{{ url()->previous() }}">Back</a>
    <form action="{{ route('training.update', ['training' => $training->id]) }}" method="post">
        @method('put')
        @csrf
        <article class="container">
            <h1>Update Training</h1>
            <p>Update training for an employee here. </p>
            <span class="required">*</span><label>School/Site</label>
            <select name="site" class="form-control @error('site') border-danger @enderror">
                <option @if (old('site') == '--' || $training->site == "") {{ 'selected' }} @endif>--</option>
                <option @if ( old('site') == '100 Mile Elementary' || $training->site == "100 Mile Elementary") {{ 'selected' }} @endif>100 Mile Elementary
                </option>
                <option @if (old('site') == '100 Mile Maintenance' || $training->site == "100 Mile Maintenance") {{ 'selected' }} @endif>100 Mile
                    Maintenance
                </option>
                <option @if (old('site') == '150 Mile Elementary' || $training->site == "150 Mile Elementary") {{ 'selected' }} @endif>150 Mile Elementary
                </option>
                <option @if (old('site') == 'Alexis Creek' || $training->site == "Alexis Creek") {{ 'selected' }} @endif>Alexis Creek</option>
                <option @if (old('site') == 'Anahim' || $training->site == "Anahim") {{ 'selected' }} @endif>Anahim</option>
                <option @if (old('site') == 'Big Lake' || $training->site == "Big Lake") {{ 'selected' }} @endif>Big Lake</option>
                <option @if (old('site') == 'Board Office' || $training->site == "Board Office") {{ 'selected' }} @endif>Board Office</option>
                <option @if (old('site') == 'Cataline' || $training->site == "Cataline") {{ 'selected' }} @endif>Cataline</option>
                <option @if (old('site') == 'Chilcotin Road' || $training->site == "Chilcotin Road") {{ 'selected' }} @endif>Chilcotin Road</option>
                <option @if (old('site') == 'Dog Creek' || $training->site == "Dog Creek") {{ 'selected' }} @endif>Dog Creek</option>
                <option @if (old('site') == 'Forest Grove' || $training->site == "Forest Grove") {{ 'selected' }} @endif>Forest Grove</option>
                <option @if (old('site') == 'Horse Lake' || $training->site == "Horse Lake") {{ 'selected' }} @endif>Horse Lake</option>
                <option @if (old('site') == 'Horsefly' || $training->site == "Horsefly") {{ 'selected' }} @endif>Horsefly</option>
                <option @if (old('site') == 'GROW WL' || $training->site == "GROW WL") {{ 'selected' }} @endif>GROW WL</option>
                <option @if (old('site') == 'Lac La Hache' || $training->site == "Lac La Hache") {{ 'selected' }} @endif>Lac La Hache</option>
                <option @if (old('site') == 'LCS-Williams Lake' || $training->site == "LCS-Williams Lake") {{ 'selected' }} @endif>LCS-Williams Lake
                </option>
                <option @if (old('site') == 'LCS-Columneetza' || $training->site == "LCS-Columneetza") {{ 'selected' }} @endif>LCS-Columneetza
                </option>
                <option @if (old('site') == 'Likely' || $training->site == "Likely") {{ 'selected' }} @endif>Likely</option>
                <option @if (old('site') == 'Marie Sharpe' || $training->site == "Marie Sharpe") {{ 'selected' }} @endif>Marie Sharpe</option>
                <option @if (old('site') == 'Mile 108 Elementary' || $training->site == "Mile 108 Elementary") {{ 'selected' }} @endif>Mile 108 Elementary
                </option>
                <option @if (old('site') == 'Mountview' || $training->site == "Mountview") {{ 'selected' }} @endif>Mountview</option>
                <option @if (old('site') == 'Maintenance Yard' || $training->site == "Maintenance Yard") {{ 'selected' }} @endif>Maintenance Yard
                </option>
                <option @if (old('site') == 'Naughtaneqed' || $training->site == "Naughtaneqed") {{ 'selected' }} @endif>Naughtaneqed</option>
                <option @if (old('site') == 'Nenqayni' || $training->site == "Nenqayni") {{ 'selected' }} @endif>Nenqayni</option>
                <option @if (old('site') == 'Nesika' || $training->site == "Nesika") {{ 'selected' }} @endif>Nesika</option>
                <option @if (old('site') == 'PSO' || $training->site == "PSO") {{ 'selected' }} @endif>PSO</option>
                <option @if (old('site') == 'Support Services' || $training->site == "Support Services") {{ 'selected' }} @endif>Support Services
                </option>
                <option @if (old('site') == 'Tatla Lake' || $training->site == "Tatla Lake") {{ 'selected' }} @endif>Tatla Lake</option>
            </select>
            <div class="form-group">
                @error("site")
                <p class="text-danger">{{ $errors->first("site") }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="course"><span class="required">*</span>Course</label>
                <input class="form-control @error('course') border-danger @enderror" type="text" name="course" placeholder="Course" required
                       value="{{ old('course') ?? $training->course}}">
                @error('course')
                <p class="text-danger">{{ $errors->first('course') }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control @error('description') border-danger @enderror" name="description"
                          placeholder="Description">{{ old('description') ?? $training->description}}</textarea>
                @error('description')
                <p class="text-danger">{{ $errors->first('description') }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="email"><span class="required">*</span>Employee Email</label>
                <button type="button"
                        class="help"
                        data-container="body"
                        data-toggle="popover"
                        data-placement="right"
                        data-content="Give the email of the employee who completed the training">
                    <b>?</b>
                </button>
                <input class="form-control @error('email') border-danger @enderror" name="email"
                       placeholder="Email" value="{{ old('email') ?? $training->email}}">
                @error('email')
                <p class="text-danger">{{ $errors->first('email') }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="course_date"><span class="required">*</span>Course Date</label>
                <input class="form-control @error('course_date') border-danger @enderror" type="date" name="course_date" placeholder="Course Date" required
                       value="{{ old('course_date') ?? $training->course_date}}">
                @error('course_date')
                <p class="text-danger">{{ $errors->first('course_date') }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="expiry_date">Expiry Date</label>
                <input class="form-control @error('expiry_date') border-danger @enderror" type="date" name="expiry_date" placeholder="Expiry date" required
                       value="{{ old('expiry_date') ?? $training->expiry_date}}">
                @error('expiry_date')
                <p class="text-danger">{{ $errors->first('expiry_date') }}</p>
                @enderror
            </div>

            <div class="form-group">
                <input type="checkbox"
                       class=" @error('designated_fa_attendant') border-danger @enderror"
                       name="designated_fa_attendant"
                       @if (old('designated_fa_attendant') || $training->designated_fa_attendant) checked @endif/>
                <label for="designated_fa_attendant">Designated First Aid Attendant?</label>
                @error('designated_fa_attendant')
                <p class="text-danger">{{ $errors->first('designated_fa_attendant') }}</p>
                @enderror
            </div>
            <label>Union</label>
            <select name="union" class="form-control @error('union') border-danger @enderror">
                <option @if(old('union') == 'CCTA' || $training->union == 'CCTA') {{ 'selected' }} @endif>CCTA</option>
                <option @if(old('union') == 'IUOE' || $training->union == 'IUOE') {{ 'selected' }} @endif>IUOE</option>
                <option @if(old('union') == 'BCPVPA' || $training->union == 'BCPVPA') {{ 'selected' }} @endif>BCPVPA</option>
                <option @if(old('union') == 'Excluded' || $training->union == 'Excluded') {{ 'selected' }} @endif>Excluded</option>
            </select>
            <div>
                @error('union')
                <p class="text-danger">{{ $errors->first('union') }}</p>
                @enderror
            </div>
            <label>Level of First Aid</label>
            <select name="fa_level" class="form-control @error('fa_level') border-danger @enderror">
                <option @if(old('fa_level') == '' || $training->fa_level == '') {{ 'selected' }} @endif></option>
                <option @if(old('fa_level') == 'Level 1' || $training->fa_level == 'Level 1') {{ 'selected' }} @endif>Level 1</option>
                <option @if(old('fa_level') == 'Level 2' || $training->fa_level == 'Level 2') {{ 'selected' }} @endif>Level 2</option>
            </select>
            <div>
                @error('fa_level')
                <p class="text-danger">{{ $errors->first('fa_level') }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="full_part_hours">Full/Part Time/Hours</label>
                <input type="text"
                       class="form-control @error('full_part_hours') border-danger @enderror"
                       name="full_part_hours"
                       value="{{ old('full_part_hours') ?? $training->full_part_hours}}">
                @error('full_part_hours')
                <p class="text-danger">{{ $errors->first('full_part_hours') }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="notes">Notes</label>
                <textarea class="form-control @error('notes') border-danger @enderror" name="notes"
                          placeholder="Notes">{{ old('notes') ?? $training->notes}}</textarea>
                @error('notes')
                <p class="text-danger">{{ $errors->first('notes') }}</p>
                @enderror
            </div>
        </article>
        <div class="container align-content-center">
            <button class="btn btn-block btn-lg btn-success" type="submit">Submit</button>
            <button class="btn btn-block btn-lg btn-secondary" type="reset">Reset</button>
        </div>

@endsection
