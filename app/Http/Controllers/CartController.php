<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
Use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    public function getCart()
    {
       if(Auth::check())
       {
            
            $userid =Auth::user()->uuid;
            $cart = Cart::where('uuid',$userid)->get();
       }
       else
       {
        $guestUuid = Cookie::get('guest_uuid');
        $cart = Cart::where('uuid',$guestUuid)->get();
       }
       foreach($cart as $cartitem)
       {
        $onsale=Sale::where('game_id', $cartitem['productId'])->first();
        if(!empty($onsale))
        {
            $cartitem['price']=$onsale->new_price;
        }
        else
        {
            $price=Product::where('id', $cartitem['productId'])->first();
            $cartitem['price']=$price;

        }

       }
        return view('cart', compact('cart'));
    }

    public function remove($productId)
    {
        if(Auth::check())
       {
            
            $userid =Auth::user()->uuid;
            $cart = Cart::where('uuid',$userid )
            ->where('productId',$productId)->get();
       }
       else
       {
        $guestUuid = Cookie::get('guest_uuid');
        $cart = Cart::where('uuid',$guestUuid )
        ->where('productId',$productId)->get();
       }

        dd($cart);

    
        return redirect()->route('cart.page')->with('success', 'Item removed from cart');
    }

    public function checkout()
    {
        
    }
}
