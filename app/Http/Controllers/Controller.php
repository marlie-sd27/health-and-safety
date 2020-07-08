<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\Forms;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $viewData;

    public function __construct()
    {
        $this->middleware(function ($request, $next)
        {
            $this->viewData = $this->loadViewData();
            return $next($request);
        });
    }

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
            $viewData['admin'] = session('admin');
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
        return view('unauthorized', $this->loadViewData());
    }

}
