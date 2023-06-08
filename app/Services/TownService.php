<?php

namespace App\Services;

use GuzzleHttp\Client;

class TownService extends IdeasoftAbstractService
{
    public function getAll()
    {
        $response = $this->client->get('/api/products',[
            'query' => [
                'client_id' => $this->clientId,
                'response_type' => 'code',
                'state' => '2b33fdd45jbevd6nam',
                'redirect_uri' => $this->redirectUri
            ]
        ]);

        return json_decode($response->getBody(), true);
    }
}
