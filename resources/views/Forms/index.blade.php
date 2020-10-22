@extends('layout')

@section('content')
<div>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <p>Any forms that are designated "live" are accessible by all users to fill in and submit. Disable a form by toggling the live switch. It won't show up on the sidebar links to forms or in the calendar deadlines. </p>
    <div class="row container">
        <table class="col-12">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Repeat Every</th>
                <th>Required For</th>
                <th>Live</th>
                <th></th>
                <th></th>
            </tr>

            @foreach($forms as $form)
                <tr>
                    <td>{{ $form->id }}</td>
                    <td><a href="{{ route('forms.show', ['form' => $form]) }}">{{ $form->title }}</a></td>
                    <td>{{ $form->interval }}</td>
                    <td>{{ $form->required_for }}</td>
                    <td>
                        <label class="switch">
                            <input type="checkbox" name="{{ $form->id }}"
                                   id="live-toggle" {{$form->live ? "checked" : ""}}>
                            <span class="slider round"></span>
                        </label>
                    </td>
                    <td><a href="{{ route('forms.edit', ['form' => $form->id]) }}"><i class="fa fa-pencil-alt"></i></a></td>
                    <td>
                        <form method="post" class="delete_form" action="{{route('forms.destroy', $form->id)}}">
                            @csrf
                            @method('delete')
                            <button type="submit" class="border-0" onclick="return confirm('Are you sure?')">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    <div class="row container align-content-center">
        <p class="col-12 text-center"><a href="{{ route('forms.create') }}" class="btn btn-success">Create New Form</a></p>
    </div>

</div>

@endsection
