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

//        // Get the access token from the cache
//        $tokenCache = new TokenCache();
//        $accessToken = $tokenCache->getAccessToken();
//
//        // Create a Graph client
//        $graph = new Graph();
//        $graph->setAccessToken($accessToken);
//
//        $queryParams = array(
//            '$select' => 'subject,organizer,start,end',
//            '$orderby' => 'createdDateTime DESC'
//        );
//
//        // Append query parameters to the '/me/events' url
//        $getEventsUrl = '/me/events?'.http_build_query($queryParams);
//
//        $events = $graph->createRequest('GET', $getEventsUrl)
//            ->setReturnType(Model\Event::class)
//            ->execute();

    }
}
