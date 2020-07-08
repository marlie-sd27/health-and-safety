<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\Forms;
use App\User;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function loadViewData()
    {
        $viewData = [];

        // Check for flash errors
        if (session('error')) {
            $viewData['error'] = session('error');
            $viewData['errorDetail'] = session('errorDetail');
        }

        // Check for logged on user
        if (session('userName'))
        {
            $user = User::where('email', session('userEmail'))->first();

            $viewData['admin'] = isset($user->admin) && $user->admin;
            $viewData['userName'] = session('userName');
            $viewData['userEmail'] = session('userEmail');
        }

        // get all the forms to create links
        $viewData['links'] = Forms::select('id', 'title')->get();

        return $viewData;
    }

    // displays Unauthorized view
    public function unauthorized()
    {
        $viewData = $this->loadViewData();
        return view('unauthorized', $viewData);
    }

}
