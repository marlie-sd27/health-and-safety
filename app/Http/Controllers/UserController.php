<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;
use App\TokenStore\TokenCache;

class UserController extends Controller
{
    public function profile()
    {

        if(session('userName'))
            return view('profile');
        else return view('signingredirect');

    }

    public function index()
    {
        $viewData = $this->loadViewData();
    }
}
