<?php

namespace App\Http\Controllers;

use App\Groups;
use App\Rules\ValidAzureObjectID;
use Illuminate\Http\Request;

class GroupsController extends Controller
{
    public function index()
    {
        return view('Manage/groups', ['groups' => Groups::all()->sortBy('name')]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'string|required',
            'azure_group_id' => ['string', 'required', new ValidAzureObjectID()],
        ]);

        Groups::create($validated);
        return redirect()->route('groups');
    }


    public function update(Request $request, Groups $groups)
    {
        return redirect()->route('groups');
    }


    public function destroy(groups $group)
    {
        Groups::destroy($group->id);
        return redirect()->route('groups');
    }
}
