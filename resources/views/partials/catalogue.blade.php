<div class="row">
    @foreach ($products as $product)
        <div class="col-md-3 mb-3">
            <div class="card h-100">
                <div class="card-body d-flex flex-column">
                    <a class="card-title" href="/catalogue/{{ $product->id }}"
                        style="font-weight: bold;">{{ $product->name }}</a>
                    <img src="{{ asset($product->image) }}" class="card-img-top" alt="{{ $product->name }}"
                        style="object-fit: cover; height: 200px;">
                    <div class="mt-auto">
                        <p class="card-text">Price: ${{ $product->price }}</p>
                        <p class="card-text">Released: {{ \Carbon\Carbon::parse($product->release_date)->format('Y') }}
                        </p>
                        <?php $genres = json_decode($product->genre, true) ?: []; ?>
                        @foreach ($genres as $genre)
                        <a href="/{{ $genre }}" class="btn btn-primary rounded-pill">{{ $genre }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

@if ($products->isEmpty())
    <p>No products found.</p>
@endif
