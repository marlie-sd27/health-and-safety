@extends('layout')

@section('content')
    <a href="{{ url()->previous() }}">Back</a>
    <div class="container">
        <h1>Manage Groups</h1>
        <p>
            Here you'll find a list of staff groups. These groups are used for assigning form deadlines to user groups.
            Add new groups and delete old groups.
        </p>
        <p>The Azure Group ID can be found in Azure Active Directory. It corresponds to the Group ID for that
            group. This is used for reporting on deadlines for a specific group. It will retrieve all users in the staff
            group and cross-reference it with the staff who have completed submissions for a deadline to determine who
            is complete.</p>
        <p><b>It is very important to change the Azure Group Object ID here if the Group Object ID on Azure is changed
                or deleted.</b></p>
        <div class="row">
            <table class="table table-bordered table-hover col-7 container">
                <tr>
                    <th>Group</th>
                    <th>Azure Group Object ID</th>
                    <th></th>
                </tr>
                @foreach($groups as $group)
                    <tr>
                        <td>{{ $group->name }}</td>
                        <td> {{ $group->azure_group_id }}</td>
                        <td>
                            <form method="post"
                                  class="delete_form float-right"
                                  action="{{route('groups.destroy', $group->id)}}">
                                @csrf
                                @method('delete')
                                <button type="submit" onclick="return confirm('Are you sure?')" class="border-0">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
            <article class="col-4 text-center container" id="create">
                <h2>Add a New group</h2>
                <form action="{{ route('groups.store') }}" method="post">
                    @csrf
                    <input type="text" name="name" class="form-control @error('name') border-danger @enderror" placeholder="Group Name" value="{{ old('name') }}" required>
                    @error('name')
                    <p class=" text-danger">{{ $errors->first('name') }}</p>
                    @enderror
                    <input type="text" name="azure_group_id" class="form-control @error('azure_group_id') border-danger @enderror" placeholder="Azure Group Object ID" value="{{ old('azure_group_id')}}" required>
                    @error('azure_group_id')
                    <p class=" text-danger">{{ $errors->first('azure_group_id') }}</p>
                    @enderror
                    <div class="container align-content-center">
                        <button class="btn btn-block btn-sm btn-success" type="submit">Save</button>
                    </div>
                </form>
            </article>
        </div>

    </div>

@endsection
