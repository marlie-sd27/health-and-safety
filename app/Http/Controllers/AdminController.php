<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('Admin/index', ['admins' => User::where('admin', true)->get()]);
    }


    public function store(Request $request)
    {

    }


    public function destroy(User $admin)
    {

    }
}
