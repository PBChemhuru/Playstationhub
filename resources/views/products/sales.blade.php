<x-app-layout>
    <div class="container mt-5">



        <div class="row">
            @foreach ($sales as $item)
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <a href="/catalogue/{{$item->game_id}}"><img src="{{ asset($item->image) }}" class="card-img-top" alt="{{ $item->name }}"
                            style="object-fit: cover; height: 200px;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $item->name }}</h5></a>
                            <p class="card-text">{{ $item->description }}</p>        
                                <s><p class="card-text font-weight-bold">${{ number_format($item->old_price, 2) }}</p></s>

                                <p class="card-text font-weight-bold">${{ number_format($item->new_price, 2) }}</p>


                            <!-- Add to Cart Form -->
                            <form action="{{ route('addcart') }}" method="POST">
                                @csrf
                                <input value="{{ $item->game_id }}" hidden id="game_id" name="game_id">

                                <!-- Quantity Controls -->
                                <div class="d-flex align-items-center">
                                    <button type="button"
                                        class="bg-gray-200 text-gray-700 hover:bg-gray-300 rounded-l-md p-2"
                                        onclick="updateQuantity('decrease', '{{ $item->id }}')">
                                        <span class="font-semibold text-lg">-</span>
                                    </button>

                                    <!-- Quantity Input -->
                                    <input type="number" id="quantity-{{ $item->id }}" name="quantity"
                                        value="1"
                                        class="w-16 text-center bg-gray-100 text-gray-800 border border-gray-300 rounded-md"
                                        min="1" readonly>

                                    <!-- Increase Button -->
                                    <button type="button"
                                        class="bg-gray-200 text-gray-700 hover:bg-gray-300 rounded-r-md p-2"
                                        onclick="updateQuantity('increase', '{{ $item->id }}')">
                                        <span class="font-semibold text-lg">+</span>
                                    </button>
                                </div>

                                <!-- Add to Cart Button -->
                                <button class="btn btn-success mt-2" type="submit">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <script>
            function updateQuantity(action, productId) {
                var quantityInput = document.getElementById('quantity-' + productId);
                var currentQuantity = parseInt(quantityInput.value);

                if (action === 'increase') {
                    quantityInput.value = currentQuantity + 1;
                } else if (action === 'decrease' && currentQuantity > 1) {
                    quantityInput.value = currentQuantity - 1;
                }
            }
        </script>


    </div>
</x-app-layout>
