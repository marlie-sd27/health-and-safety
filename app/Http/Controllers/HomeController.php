<?php
// Copyright (c) Microsoft Corporation.
// Licensed under the MIT License.

namespace App\Http\Controllers;

use App\Events;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function dashboard()
    {

        $viewData['upcomings'] = Events::with('forms')
            ->where('date', '>', Carbon::now())
            ->where('date', '<', Carbon::now()->addMonths(3))
            ->limit(5)
            ->get();

//        dd($viewData['upcomings'][0]);

        $viewData['overdues'] = [
            'Asbestos' => 'September 6, 2019',
            'Health & Safety checklist' => 'September 30, 2019'
        ];

        $viewData['completed'] = [
            'Joint Health & Safety Minutes' => 'July 6, 2020',
            'Secondary School Inspection' => 'September 30, 2020',
            'Fire Drill' => 'July 6, 2020',
            'Elementary School Inspection' => 'September 30, 2020'
        ];

        return view('dashboard', $viewData);

    }

    public function welcome()
    {
        return view('welcome');
    }


}
