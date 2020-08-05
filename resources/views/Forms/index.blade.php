@extends('layout')

@section('content')
<div>
    <table>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Recurrence Schedule</th>
            <th>Required For</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>

        @foreach($forms as $form)
            <tr>
                <td>{{ $form->id }}</td>
                <td><a href="{{ route('forms.show', ['form' => $form]) }}">{{ $form->title }}</a></td>
                <td>{{ $form->interval }}</td>
                <td>{{ $form->required_for }}</td>
                <td><a href="{{ route('forms.edit', ['form' => $form->id]) }}">Edit</a></td>
                <td>
                    <form method="post" class="delete_form" action="{{route('forms.destroy', $form->id)}}">
                        @csrf
                        @method('delete')
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

</div>

@endsection
