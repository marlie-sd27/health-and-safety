<?php

namespace App\Http\Controllers;

use App\Sites;
use Illuminate\Http\Request;

class SitesController extends Controller
{

    public function index()
    {
        return view('Manage/sites', ['sites' => Sites::all()->sortBy('site')]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'site' => 'string|required'
        ]);

        Sites::create($validated);
        return redirect()->route('sites');
    }


    public function update(Request $request, Sites $sites)
    {
        return redirect()->route('sites');
    }


    public function destroy(Sites $site)
    {
        Sites::destroy($site->id);
        return redirect()->route('sites');
    }
}
