<x-app-layout>

    @if (count($cart) > 0)
        <table class="w-full table-auto border-collapse border border-gray-200">
            <thead>
                <tr>
                    <th class="border-b p-2">Product</th>
                    <th class="border-b p-2">Price</th>
                    <th class="border-b p-2">Quantity</th>
                    <th class="border-b p-2">Total</th>
                    <th class="border-b p-2">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $totalCartValue = 0?>
                @foreach ($cart as $cartItem)
                    <tr>
                        <td class="p-2">{{ $cartItem['productName'] }}</td>
                        <td class="p-2">${{ number_format($cartItem['price'], 2) }}</td>
                        <td class="p-2">
                            <button type="button" class="bg-red-200 text-gray-700 hover:bg-gray-300 rounded-l-md p-2"
                                onclick="updateQuantity('{{ $cartItem['id'] }}', 'decrease')">
                                <span class="font-semibold text-lg">-</span>
                            </button>

                            <input type="number" value="{{ $cartItem['productQuantity'] }}"
                                class="w-16 text-center bg-gray-100 text-gray-800 border border-gray-300 rounded-md"
                                min="1" readonly>

                            <!-- Increase Button -->
                            <button type="button" class="bg-green-200 text-gray-700 hover:bg-gray-300 rounded-r-md p-2"
                                onclick="updateQuantity('{{ $cartItem['id'] }}', 'increase')">
                                <span class="font-semibold text-lg">+</span>
                            </button>
                        </td>
                        <td class="p-2">${{ number_format($cartItem['price'] * $cartItem['productQuantity'], 2) }}
                        </td>
                        <td class="p-2">
                            <!-- Optional: Add a link to remove or update the item -->
                            <form action="{{ route('deletecartitem', $cartItem->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-500 text-white px-4 py-1 rounded hover:bg-red-600">Remove</button>
                            </form>
                        </td>
                    </tr>
                    <?php $totalCartValue += number_format($cartItem['price'] * $cartItem['productQuantity'], 2) ?>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4 text-right">
            <h2 class="text-xl font-semibold">Total:{{$totalCartValue}}
            </h2>
        </div>

        <div class="mt-4">
            <!-- Proceed to checkout button -->
            <a href="{{ route('checkout') }}"
                class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600">Proceed to Checkout</a>
        </div>
    @else
        <p>Your cart is empty.</p>
    @endif

    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        function updateQuantity(id, action) {
            let url = action === 'increase' ? '{{ route('increasecart') }}' : '{{ route('decreasecart') }}';
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id

                }, // Send form data to the server
                success: function(response) {
                    // Log the returned data for debugging
                    if (response.success) {
                        console.log(response);
                        location.reload();
                    } else {
                        console.error(response);
                        alert('Failed to add item.')
                    }
                },
                error: function(xhr) {
                    console.error(xhr); // Log the error response
                    alert('An error occurred while update cart.');
                }
            });

        }
    </script>
</x-app-layout>
