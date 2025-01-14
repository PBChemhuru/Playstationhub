<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    public function getCart()
    {
        if (Auth::check()) {

            $userid = Auth::user()->uuid;
            $cart = Cart::where('uuid', $userid)->get();
        } else {
            $guestUuid = Cookie::get('guest_uuid');
            $cart = Cart::where('uuid', $guestUuid)->get();
        }
        foreach ($cart as $cartitem) {
            $onsale = Sale::where('game_id', $cartitem['productId'])->first();
            if (!empty($onsale)) {
                $cartitem['price'] = $onsale->new_price;
            } else {
                $price = Product::where('id', $cartitem['productId'])->first()->value('price');
                $cartitem['price'] = $price;
            }
        }
        return view('cart', compact('cart'));
    }

    public function deletecartitem($id)
    {
        Cart::where('id', $id)->delete();
        return redirect()->route('getCart')->with('error', 'Item removed from cart');
    }

    public function checkout() {}

    public function addcart(Request $request)
    {
        $productId = $request->game_id;
        $cartItem['productId'] = $productId;
        $quantity = $request->quantity;

        if ((Sale::where('game_id', $productId)->get())->isNotEmpty()) {
            $salesProduct = Sale::where('game_id', $productId)->first();
            $cartItem['price'] = $salesProduct->new_price;
            $cartItem['productName'] = $salesProduct->name;
            $cartItem['productQuantity'] = $quantity;
            $cartItem['image'] = $salesProduct->image;
        } else {
            $products = Product::where('id',$productId)->first();
            $cartItem['price'] = $products->price;
            $cartItem['productName'] = $products->name;
            $cartItem['productQuantity'] =  $quantity;
            $cartItem['image'] = $products->image;
        }


        if (Auth::check()) {

            $userid = Auth::user()->uuid;
            $cartItem['uuid'] = $userid;
        } else {
            $guestUuid = Cookie::get('guest_uuid');
            $cartItem['uuid'] = $guestUuid;
        }
        $addOnCheck = Cart::where('uuid', $cartItem['uuid'])
            ->where('productId', $cartItem['productId'])->first();
        if (!empty($addOnCheck)) {
            $addTotal = $addOnCheck['productQuantity'] + $cartItem['productQuantity'];
            Cart::where('uuid', $cartItem['uuid'])
                ->where('productId', $cartItem['productId'])->update(['productQuantity' => $addTotal]);
        } else {
            Cart::create($cartItem);
        }

        return redirect()->route('getCatalogue')->with('success', 'Product added to cart successfully!');
    }

    public function increaseQuantity(Request $request)
    {
        $cartItemId = $request->input('id');
        $increment = Cart::where('id', $cartItemId)->value('productQuantity');
        $increment += 1;
        Cart::where('id', $cartItemId)->update(['productQuantity' => $increment]);

        return response()->json(['success' => true]);
    }

    public function decreaseQuantity(Request $request)
    {
        $cartItemId = $request->input('id');
        $decrement = Cart::where('id', $cartItemId)->value('productQuantity');
        $decrement -= 1;
        Cart::where('id', $cartItemId)->update(['productQuantity' => $decrement]);

        return response()->json(['success' => true]);
    }
}
