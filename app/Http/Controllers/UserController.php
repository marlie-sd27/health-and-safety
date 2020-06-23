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
        $viewData = $this->loadViewData();

        if(isset($viewData['userName']))
            return view('profile', $viewData);
        else return view('signingredirect', $viewData);

    }

    public function index()
    {
        $viewData = $this->loadViewData();
    }
}
