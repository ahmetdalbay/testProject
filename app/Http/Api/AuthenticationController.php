<?php

namespace App\Http\Api;

use App\Http\Controllers\Controller;
use App\Models\UserClient;
use App\Models\UserToken;
use App\Services\AuthenticationService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthenticationController extends Controller
{
    public $service;

    public function __construct(AuthenticationService $service)
    {
        $this->service = $service;
    }

    public function grantAccess(int $clientId)
    {
        $userClient = UserClient::find($clientId);
        $state = Str::random(20);

        $url = $userClient->base_uri .'/panel/auth?' .
            'client_id' . '=' . $userClient->client_id . '&' .
            'response_type' . '=' . 'code' . '&' .
            'state' . '=' . $state . '&' .
            'redirect_uri' . '=' . 'http://localhost/callback';

        return redirect()->to($url);
    }

    public function callback(Request $request)
    {
        $code = $request->query('code');
        $userClient = UserClient::where('base_uri', $request->query('domain'))->first();

        $response = $this->service->accessToken($userClient,$code);
        $response = json_decode($response->getBody(), true);

        $userToken = new UserToken();
        $userToken->user_id = $userClient->user_id;
        $userToken->client_id = $userClient->id;
        $userToken->access_token = data_get($response, 'access_token');
        $userToken->refresh_token = data_get($response, 'refresh_token');
        $userToken->save();

        return redirect()->route('platform.main');
    }
}
