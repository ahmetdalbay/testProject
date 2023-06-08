@if($clients->count())
    <div class="card">
        <div class="card-header">
            API
        </div>
        @foreach($clients as $client)
            <div class="card-body">
                <h5 class="card-title"></h5>
                <p class="card-text">
                    {{ $client->name . ' - ' . $client->base_uri }}
                </p>
                <a href="{{ route('grant-access',$client->id) }}" class="btn btn-primary">Yetkilendir</a>
            </div>
        @endforeach
    </div>
@else
    <div class="alert alert-warning" role="alert">
        Henüz API Tanımlaması Yapmadınız. İsterseniz <a href="{{ route('platform.client.edit') }}" class="fw-bold">Buradan</a> API Tanımlaması Yapabilirsiniz.
    </div>
@endif
