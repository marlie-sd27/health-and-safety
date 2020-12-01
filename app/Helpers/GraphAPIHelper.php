<?php


namespace App\Helpers;


use App\Groups;
use App\Sites;
use App\TokenStore\TokenCache;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model\User;

class GraphAPIHelper
{
    // set up API with token
    private static function prepareAPI()
    {
        // build query to get user data
        $tokenCache = new TokenCache();

        $graph = new Graph();
        $graph->setAccessToken($tokenCache->getAccessToken());

        return $graph;
    }


    // get all staff
    public static function getAllStaff()
    {
        $graph = self::prepareAPI();

        $allStaffGroup = Groups::firstWhere('name', 'All SD27 Staff');

        //build and execute query to pull all staff
        $queryParams = array(
            '$select' => 'displayName,mail,jobTitle,department',
            '$top' => 999,
            '$count' => 'true',
            '$filter' => 'endsWith(mail,\'@sd27.bc.ca\')',
        );
        $getAllStaffURL = "/groups/{$allStaffGroup->azure_group_id}/members?" . http_build_query($queryParams);

        // execute query
        $response = $graph->createRequest('GET', $getAllStaffURL)
            ->addHeaders(['ConsistencyLevel' => 'eventual'])
            ->execute();

        // get users returned from query
        $users = $response->getResponseAsObject(User::class);

        // if there's another page of users, execute query to get those users
        if($response->getNextLink())
        {
            $response = $graph->createRequest('GET', $response->getNextLink())
                ->addHeaders(['ConsistencyLevel' => 'eventual'])
                ->execute();

            // append each user returned to the users array
            foreach($response->getResponseAsObject(User::class) as $user)
            {
                array_push($users, $user);
            }
        }

        return $users;
    }


    // get all staff at a specified site
    public static function getSiteStaff(Sites $site)
    {
        return self::getAzureGroupStaff($site->azure_group_id);
    }


    // retrieve all staff in a specified group
    public static function getGroupStaff(Groups $group)
    {
        return self::getAzureGroupStaff($group->azure_group_id);
    }


    // get staff from azure group
    private static function getAzureGroupStaff($azure_group_id)
    {
        $graph = self::prepareAPI();

        //build and execute query to pull group members for specified site
        $queryParams = array(
            '$select' => 'displayName,mail,jobTitle,department',
            '$top' => 999,
        );
        $getUsersUrl = "/groups/{$azure_group_id}/members?" . http_build_query($queryParams);

        return $graph->createRequest('GET', $getUsersUrl)
            ->execute()
            ->getResponseAsObject(User::class);
    }
}
