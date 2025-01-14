<x-app-layout>
    <?php
        $things=$item->genre;
        $genres =explode(',',$things);
    ?>
    <div class="container" style="margin-top: 10pt;">
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="{{ asset($item->image) }}" class="card-img-top" alt="Product Name"
                        style="object-fit: cover; height: 200px;">
                    <div class="card-body d-flex flex-column">

                        <h5 class="card-title">{{ $item->name }}</h5>
                        <p class="card-text">{{ $item->description }}</p>
                        <?php
                        $onsale= DB::table('sales')->where('game_id',$item->id)->first();
                        ?>
                        @if(empty($onsale))
                        <p class="card-text font-weight-bold">{{ $item->price }}</p>
                        @else
                         <p class="card-text font-weight-bold">{{ $onsale->new_price }}</p>
                        @endif
                        @foreach($genres as $genre)
                        <p class="inline-flex items-center">
                            <!-- Blue circle with a white dot -->
                            <span class="w-2.5 h-2.5 bg-white rounded-full mr-2"></span>
                            
                            <!-- Genre Text with link -->
                            <a href="/{{$genre}}" class="text-blue-600 bg-blue-100 px-2 py-1 rounded-full hover:bg-blue-200">
                                {{$genre}}
                            </a>
                        </p>
                        @endforeach
                        
                        <form action="{{ route('addcart') }}" method="POST">
                            @csrf
                            <input value="{{ $item->id }}" hidden id="game_id" name="game_id">
                            <button type="button" class="bg-gray-200 text-gray-700 hover:bg-gray-300 rounded-l-md p-2"
                                onclick="updateQuantity('decrease')">
                                <span class="font-semibold text-lg">-</span>
                            </button>

                            <!-- Quantity Input Field -->
                            <input type="number" id="quantity" name="quantity" value="1"
                                class="w-16 text-center bg-gray-100 text-gray-800 border border-gray-300 rounded-md"
                                min="1" readonly>

                            <!-- Increase Button -->
                            <button type="button" class="bg-gray-200 text-gray-700 hover:bg-gray-300 rounded-r-md p-2"
                                onclick="updateQuantity('increase')">
                                <span class="font-semibold text-lg">+</span>
                            </button>
                            <button class="btn btn-success"type="submit">Add to cart</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function updateQuantity(action) {
                let quantityInput = document.getElementById('quantity');
                let currentQuantity = parseInt(quantityInput.value);
        
                if (action === 'increase') {
                    quantityInput.value = currentQuantity + 1;
                } else if (action === 'decrease' && currentQuantity > 1) {
                    quantityInput.value = currentQuantity - 1;
                }
            }
        </script>

        </x-guest-layout>
