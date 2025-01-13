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
                @foreach ($cart as $cartItem)
                    <tr>
                        <td class="p-2">{{ $cartItem['productName'] }}</td>
                        <td class="p-2">${{ number_format($cartItem['price'], 2) }}</td>
                        <td class="p-2">
                            <input type="number" value="{{ $cartItem['productQuantity'] }}"
                                class="w-16 text-center bg-gray-100 text-gray-800 border border-gray-300 rounded-md"
                                min="1" readonly>
                        </td>
                        <td class="p-2">${{ number_format($cartItem['price'] * $cartItem['productQuantity'], 2) }}</td>
                        <td class="p-2">
                            <!-- Optional: Add a link to remove or update the item -->
                            <form action="{{ route('cart.remove', $cartItem->productId) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-500 text-white px-4 py-1 rounded hover:bg-red-600">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="mt-4 text-right">
            <h2 class="text-xl font-semibold">Total:
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
    @php
        $check = [];
        foreach ($cart as $productId => $item) {
            $check[] = $item['name'];
        }
        session(['check' => $check]);
    @endphp
    </div>
    <script>
        var Check = [];
        @foreach ($cart as $productId => $item)
            Check.push("{{ $item['name'] }}");
        @endforeach
    </script>
</x-app-layout>
