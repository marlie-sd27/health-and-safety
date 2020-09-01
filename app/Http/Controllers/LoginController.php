<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use League\OAuth2\Client\Provider\GenericProvider;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;
use App\TokenStore\TokenCache;
use Throwable;

class LoginController extends Controller
{
    public function signin()
    {
        // Initialize the OAuth client
        $oauthClient = new GenericProvider([
            'clientId'                => env('OAUTH_APP_ID'),
            'clientSecret'            => env('OAUTH_APP_PASSWORD'),
            'redirectUri'             => env('OAUTH_REDIRECT_URI'),
            'urlAuthorize'            => env('OAUTH_AUTHORITY').env('OAUTH_AUTHORIZE_ENDPOINT'),
            'urlAccessToken'          => env('OAUTH_AUTHORITY').env('OAUTH_TOKEN_ENDPOINT'),
            'urlResourceOwnerDetails' => '',
            'scopes'                  => env('OAUTH_SCOPES')
        ]);

        $authUrl = $oauthClient->getAuthorizationUrl();

        // Save client state so we can validate in callback
        session(['oauthState' => $oauthClient->getState()]);

        // Redirect to AAD signin page
        return redirect()->away($authUrl);
    }

    public function callback(Request $request)
    {
        // Validate state
        $expectedState = session('oauthState');
        $request->session()->forget('oauthState');
        $providedState = $request->query('state');

        if (!isset($expectedState)) {
            // If there is no expected state in the session,
            // do nothing and redirect to the home page.
            return redirect('/');
        }

        if (!isset($providedState) || $expectedState != $providedState) {
            return redirect('/')
                ->with('error', 'Invalid auth state')
                ->with('errorDetail', 'The provided auth state did not match the expected value');
        }

        // Authorization code should be in the "code" query param
        $authCode = $request->query('code');
        if (isset($authCode)) {
            // Initialize the OAuth client
            $oauthClient = new GenericProvider([
                'clientId'                => env('OAUTH_APP_ID'),
                'clientSecret'            => env('OAUTH_APP_PASSWORD'),
                'redirectUri'             => env('OAUTH_REDIRECT_URI'),
                'urlAuthorize'            => env('OAUTH_AUTHORITY').env('OAUTH_AUTHORIZE_ENDPOINT'),
                'urlAccessToken'          => env('OAUTH_AUTHORITY').env('OAUTH_TOKEN_ENDPOINT'),
                'urlResourceOwnerDetails' => '',
                'scopes'                  => env('OAUTH_SCOPES')
            ]);

            try {
                // Make the token request
                $accessToken = $oauthClient->getAccessToken('authorization_code', [
                    'code' => $authCode
                ]);

                // save tokens in cache
                $tokenCache = new TokenCache();
                $tokenCache->storeTokens($accessToken);

                $graph = new Graph();
                $graph->setAccessToken($accessToken->getToken());

                $user = $graph->createRequest('GET', '/me')
                    ->setReturnType(Model\User::class)
                    ->execute();


                // build query to get membership groups
                $principal = false;
                $queryParams = array(
                    '$select' => 'displayName',
                );
                $getEventsUrl = '/me/memberOf?'.http_build_query($queryParams);

                $groups = $graph->createRequest('GET', $getEventsUrl)
                    ->setReturnType(Model\Group::class)
                    ->execute();

                foreach($groups as $group)
                {
                    if ($group->getdisplayName() == "All Principals and Vice Principals")
                    {
                        $principal = true;
                    }
                    if ($group->getdisplayName() == "All Elementary Principals")
                    {
                        $elementary = true;
                    }
                }

                // search to see if user already exists
                $localUser = User::where('email', strtolower($user->getMail()))->first();

                // if localUser is not found in database, create one
                if (!$localUser)
                {
                    $localUser = User::create([
                        'name' => $user->getDisplayName(),
                        'email' => strtolower($user->getMail()),
                        'admin' => false,
                        'principal' => $principal,
                        'elementary_principal' => $elementary,
                        'last_login' => Carbon::now()->format('Y-m-d H:i:s'),
                    ]);

                    // otherwise update the principal status and last login timestamp
                } else {
                    $localUser->update([
                        'principal' => $principal,
                        'elementary_principal' => $elementary,
                        'last_login' => Carbon::now()->format('Y-m-d H:i:s'),
                    ]);
                    $localUser->save();
                }


                // attempt to login
                try {
                    Auth::login($localUser);
                } catch(Throwable $exception){
                    return "Failed to Auth";
                }

                return redirect()->intended('dashboard');
            }
            catch (League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
                return redirect('/')
                    ->with('error', 'Error requesting access token')
                    ->with('errorDetail', $e->getMessage());
            }
        }

        return redirect('/')
            ->with('error', $request->query('error'))
            ->with('errorDetail', $request->query('error_description'));
    }

    public function signout()
    {
        $tokenCache = new TokenCache();
        $tokenCache->clearTokens();
        Auth::logout();
        return redirect('/');
    }



}
