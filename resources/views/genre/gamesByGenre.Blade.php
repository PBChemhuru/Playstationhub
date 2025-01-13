<x-app-layout>
        <div class="container-fluid">
            <div class="row my-10">
                <div class="image-container" style="text-align: center;width: 100%">
                    <img src="{{ asset('images/banner.jpg') }}" alt="Description of Image" style="width: 100%;height:400px">
                </div>
            </div>

            <div class="row my-10 mx-10">
                <h2 class="text-center">{{ $genres }} Games</h2><br>
                @if ($games->isEmpty())
                    <p class="text-center">No games found for this genre.</p>
                @else
                    @foreach ($games as $game)
                        <div class="col-3 my-2">
                            <div class="card">
                                <img src="{{ asset($game->image_path) }}" class="card-img-top" alt="{{ $game->title }}" style="height: 250px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $game->name }}</h5>
                                    <p class="card-text">{{ Str::limit($game->price, 100) }}</p>
                                    <a href="/catalogue/{{$game->id}}" class="btn btn-primary">View Details</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

        </div>
</x-app-layout>