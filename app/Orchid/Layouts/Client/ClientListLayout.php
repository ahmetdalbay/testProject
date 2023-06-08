<?php

namespace App\Orchid\Layouts\Client;

use App\Models\UserClient;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Alert;

class ClientListLayout extends Table
{
    /**
     * Data source.
     *
     * @var string
     */
    public $target = 'client';

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('name', 'Uygulama Adı')
                ->render(function (UserClient $client) {
                    return Link::make($client->name)
                        ->route('platform.client.edit', $client);
                }),
            TD::make('base_uri', 'Site URL'),
            TD::make('client_id', 'Client ID'),
            TD::make('client_secret', 'Client Secret'),
        ];
    }
}
