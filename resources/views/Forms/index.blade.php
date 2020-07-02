@extends('layout')

@section('content')
<div class="container">
    <table>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Recurrence Schedule</th>
            <th>Required For</th>
            <th>Full Year?</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>

        @foreach($forms as $form)
            <tr>
                <td>{{ $form->id }}</td>
                <td><a href="{{ route('forms.show', ['form' => $form]) }}">{{ $form->title }}</a></td>
                <td>{{ $form->description }}</td>
                <td>{{ $form->recurrence }}</td>
                <td>{{ $form->required_role }}</td>
                <td>{{ $form->full_year }}</td>
                <td><a href="{{ route('forms.edit', ['form' => $form->id]) }}">Edit</a></td>
                <td><a href="{{ route('forms.destroy', ['form' => $form->id]) }}">Delete</a></td>
            </tr>
        @endforeach
    </table>

</div>

@endsection
