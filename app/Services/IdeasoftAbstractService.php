<?php

namespace App\Services;

use App\Models\UserClient;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

abstract class IdeasoftAbstractService
{
    public $baseUri;
    public $redirectUri = 'http://localhost/callback';
    public $clientId;
    public $clientSecret;

    public function __construct()
    {

    }
}
