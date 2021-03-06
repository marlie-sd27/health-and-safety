<?php


namespace App\Helpers;


use App\Groups;
use App\Sites;
use App\TokenStore\TokenCache;
use GuzzleHttp\Exception\ClientException;
use http\Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model\User;

class GraphAPIHelper
{
    // set up API with token
    private static function prepareAPI()
    {
        // build query to get user data
        $tokenCache = new TokenCache();

        $token = $tokenCache->getAccessToken() == '' ? self::getToken() : $tokenCache->getAccessToken();

        $graph = new Graph();
        $graph->setAccessToken($token);

        return $graph;
    }


    // request a token on behalf of the application
    private static function getToken()
    {
        $response =  Http::asForm()
            ->withHeaders([
                'Host' => 'login.microsoftonline.com',
                'Content-Type' => 'application/x-www-form-urlencoded'
            ])
            ->post(env('OAUTH_AUTHORITY') . env('OAUTH_TOKEN_ENDPOINT'), [
                'grant_type' => 'client_credentials',
                'client_id' => env('OAUTH_APP_ID'),
                'scope' => 'https://graph.microsoft.com/.default',
                'client_secret' => env('OAUTH_APP_PASSWORD'),
            ]);

        return $response['access_token'];
    }


    // get all staff
    public static function getAllStaff()
    {
        $allStaffGroup = Groups::firstWhere('name', 'All SD27 Staff');

        return self::getAzureGroupStaff($allStaffGroup->azure_group_id);
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
            '$count' => 'true',
            '$filter' => 'endsWith(mail,\'@sd27.bc.ca\')',
        );
        $getUsersUrl = "/groups/{$azure_group_id}/members?" . http_build_query($queryParams);

        try {
            // execute query
            $response = $graph->createRequest('GET', $getUsersUrl)
                ->addHeaders(['ConsistencyLevel' => 'eventual'])
                ->execute();

            // get users returned from query
            $users = $response->getResponseAsObject(User::class);

            // if there's another page of users, execute query to get those users
            if ($response->getNextLink()) {
                $response = $graph->createRequest('GET', $response->getNextLink())
                    ->addHeaders(['ConsistencyLevel' => 'eventual'])
                    ->execute();

                // append each user returned to the users array
                foreach ($response->getResponseAsObject(User::class) as $user) {
                    array_push($users, $user);
                }
            }

            return $users;
        } catch (ClientException $e) {
            Log::debug($e);
            return null;
        }
    }


    // test that give Azure Object ID is valid and exists
    public static function testAzureObjectIDValidity($azure_object_id)
    {
        $graph = self::prepareAPI();

        $getGroupURL = "/groups/{$azure_object_id}";

        try {
            $response = $graph->createRequest('GET', $getGroupURL)
                ->execute();
        } catch (ClientException $e) {
            return false;
        }

        return $response->getStatus() == '200';
    }
}
