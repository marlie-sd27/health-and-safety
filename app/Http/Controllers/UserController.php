<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;
use App\TokenStore\TokenCache;

class UserController extends Controller
{
    public function profile()
    {
        return view('Users/profile');
    }

}
