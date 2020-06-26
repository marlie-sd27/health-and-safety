<?php
// Copyright (c) Microsoft Corporation.
// Licensed under the MIT License.

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function welcome()
    {
        $viewData = $this->loadViewData();

        $viewData['overdues'] = [
            'Asbestos' => 'September 6, 2019',
            'Health & Safety checklist' => 'September 30, 2019'
        ];

        $viewData['upcomings'] = [
            'Fire Drill' => 'July 6, 2020',
            'Elementary School Inspection' => 'September 30, 2020'
        ];

        $viewData['completed'] = [
            'Joint Health & Safety Minutes' => 'July 6, 2020',
            'Secondary School Inspection' => 'September 30, 2020',
            'Fire Drill' => 'July 6, 2020',
            'Elementary School Inspection' => 'September 30, 2020'
        ];

        return view('welcome', $viewData);

    }
}
