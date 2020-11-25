<?php


namespace App\Helpers;


use App\TokenStore\TokenCache;
use Microsoft\Graph\Graph;

class GraphAPIHelper
{
    public function prepareAPI()
    {
        // build query to get user data
        $tokenCache = new TokenCache();

        $graph = new Graph();
        $graph->setAccessToken($tokenCache->getAccessToken());

        return $graph;
    }


    public function getAllStaff()
    {
        $graph = $this->prepareAPI();

        //build and execute query to pull all staff
        $queryParams = array(
            '$select' => 'displayName,mail,jobTitle,department',
            '$top' => 999,
        );
        $getAllStaff = "/groups/{$site->azure_group_id}/members?" . http_build_query($queryParams);

        $users = $graph->createRequest('GET', $getUsersUrl)
            ->execute();
    }
}
