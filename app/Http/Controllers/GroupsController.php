<?php

namespace App\Http\Controllers;

use App\Groups;
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
            'group' => 'string|required',
            'azure_group_id' => 'string|required',
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
