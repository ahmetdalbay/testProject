<?php

namespace App\Orchid\Screens\Client;

use App\Models\UserClient;
use App\Models\UserToken;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class ClientEditScreen extends Screen
{
    /**
     * @var UserClient
     */
    public $client;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(UserClient $client): iterable
    {
        return [
            'client' => $client
        ];
    }


    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return '';
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->client->exists ? 'API Düzenle' : 'API Ekle';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Ekle')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->client->exists),

            Button::make('Kaydet')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->client->exists),

            Button::make('Sil')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->client->exists),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::rows([
                Input::make('client.name')
                    ->title('Uygulama Adı')->required(),

                Input::make('client.base_uri')
                    ->title('Site URL')->required(),

                Input::make('client.client_id')
                    ->title('Client ID')->required(),

                Input::make('client.client_secret')
                    ->title('Client Secret')->required(),
            ])
        ];
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(Request $request)
    {
        $data = $request->get('client');

        if (substr($data['base_uri'], -1) === '/') {
            $data['base_uri'] = rtrim($data['base_uri'], '/');
        }
        $data['user_id'] = auth()->user()->id;

        $this->client->fill($data)->save();

        if ($this->client->wasRecentlyCreated) {
            Alert::success('Kayıt İşlemi Başarılı');
        } else {
            Alert::info('Düzenleme İşlemi Başarılı');
        }

        return redirect()->route('platform.client.list');
    }

    /**
     * @param UserClient $client
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(UserClient $client)
    {
        UserToken::where('client_id', $client->id)->delete();
        $client->delete();


        Alert::info('Silme İşlemi Başarılı');

        return redirect()->route('platform.client.list');
    }
}
