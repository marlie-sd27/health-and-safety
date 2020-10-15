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
                <option @if (old('site') == '' || $training->site == "") {{ 'selected' }} @endif></option>
                @foreach($sites as $site)
                    <option @if ( old('site') == $site->site || $training->site == $site->site) {{ 'selected' }} @endif>
                        {{$site->site}}</option>
                @endforeach
            </select>
            <div class="form-group">
                @error("site")
                <p class="text-danger">{{ $errors->first("site") }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="course"><span class="required">*</span>Course</label>
                <select name="course" class="form-control @error('course') border-danger @enderror">
                    <option @if (old('course') == '' || $training->course == "") {{ 'selected' }} @endif></option>
                    @foreach($courses as $course)
                        <option @if ( old('course') == $course->course || $training->course == $course->course) {{ 'selected' }} @endif>
                            {{$course->course}}</option>
                    @endforeach
                </select>
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
                       @if (is_array(old('designated_fa_attendant')) || $training->designated_fa_attendant ) checked @endif/>
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
            <label>Level of First Aid Required by WorkSafe at this site</label>
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
