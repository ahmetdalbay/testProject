<?php

namespace App\Http\Middleware;

use App\Services\AuthenticationService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class CheckAccessTokenValidity
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $latestToken = auth()->user()->latestToken;

        if ($latestToken) {
            $baseUri = $latestToken->client->base_uri;
            $response = Http::withToken($latestToken->access_token)->get($baseUri . '/api/regions');

            if ($response->successful()) {
                return $next($request);
            } else {
                $service = new AuthenticationService();
                $response = $service->refreshToken($latestToken->client, $latestToken->refresh_token);

                if ($response->successful()) {
                    $latestToken->access_token = data_get($response, 'access_token');
                    $latestToken->refresh_token = data_get($response, 'refresh_token');
                    $latestToken->save();

                    return $next($request);
                }else {
                    return redirect()->route('platform.client.list')->withErrors(['Lütfen API Bilgilerinizi Kontrol Ediniz.']);
                }
            }
        }

        return redirect()->route('platform.grant-access');
    }
}
