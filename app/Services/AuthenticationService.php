<?php

namespace App\Services;

use App\Models\UserClient;
use Illuminate\Support\Facades\Http;

class AuthenticationService extends IdeasoftAbstractService
{
    public function accessToken(UserClient $userClient, $code)
    {
        $response = Http::get($userClient->base_uri . '/oauth/v2/token', [
            'grant_type' => 'authorization_code',
            'client_id' => $userClient->client_id,
            'client_secret' => $userClient->client_secret,
            'code' => $code,
            'redirect_uri' => $this->redirectUri,
        ]);

        return $response;
    }

    public function refreshToken(UserClient $userClient, $refreshToken)
    {
        $response = Http::get($userClient->base_uri . '/oauth/v2/token', [
            'grant_type' => 'refresh_token',
            'client_id' => $userClient->client_id,
            'client_secret' => $userClient->client_secret,
            'refresh_token' => $refreshToken,
        ]);

        return $response;
    }

}
