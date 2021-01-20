@extends('layout')

@section('content')
    <a href="{{ url()->previous() }}">Back</a>
    <div class="container">
        <h1>Manage Sites</h1>
        <p>
            Here you'll find a list of all the sites in our District. These sites are listed in drop down
            menus of forms and training entries. Add new sites and delete old sites.
        </p>
        <p>The Azure Group ID can be found in Azure Active Directory. It corresponds to the Staff Group ID for that
            site. This is used for reporting on deadlines for a specific site. It will retrieve all users in the staff
            group and cross-reference it with the staff who have completed submissions for a deadline to determine who
            is complete.</p>
        <p><b>It is very important to change the Azure Group Object ID here if the Group Object ID on Azure is changed or deleted.</b></p>
        <div class="row">
            <table class="table table-bordered table-hover col-8 container">
                <tr>
                    <th>Site</th>
                    <th>Azure Group Object ID</th>
                    <th>Site Code</th>
                    <th></th>
                </tr>
                @foreach($sites as $site)
                    <tr>
                        <td>{{ $site->site }}</td>
                        <td> {{ $site->azure_group_id }}</td>
                        <td>{{ $site->code }}</td>
                        <td>
                            <form method="post"
                                  class="delete_form float-right"
                                  action="{{route('sites.destroy', $site->id)}}">
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
            <article class="col-3 text-center container" id="create">
                <h2>Add a New Site</h2>
                <form action="{{ route('sites.store') }}" method="post">
                    @csrf
                    @csrf
                    <input type="text" name="site" class="form-control @error('site') border-danger @enderror" placeholder="Site Name" value="{{ old('site') }}" required>
                    @error('site')
                    <p class=" text-danger">{{ $errors->first('site') }}</p>
                    @enderror
                    <input type="text" name="azure_group_id" class="form-control @error('azure_group_id') border-danger @enderror" placeholder="Azure Group Object ID" value="{{ old('azure_group_id')}}" required>
                    @error('azure_group_id')
                    <p class=" text-danger">{{ $errors->first('azure_group_id') }}</p>
                    @enderror
                    <input type="number" name="code" class="form-control @error('code') border-danger @enderror" placeholder="Site Code" value="{{ old('code') }}" required/>
                    @error('code')
                    <p class=" text-danger">{{ $errors->first('code') }}</p>
                    @enderror
                    <div class="container align-content-center">
                        <button class="btn btn-block btn-sm btn-success" type="submit">Save</button>
                    </div>
                </form>
            </article>
        </div>

    </div>

@endsection
