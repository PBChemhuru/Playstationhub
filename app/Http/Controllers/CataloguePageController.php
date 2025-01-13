<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class CataloguePageController extends Controller
{
    public function getItem($id)
    {
        $item = Product::where('id',$id)->get()->first();
        return view('catalogue.item',compact('item'));
    }

    public function filter(Request $request)
    {
        $genres = $request->input('genres',[]);
        $years = $request->input('years',[]);

        $query =Product::query();

        if (!empty($genres))
        {
            $query->wherein('genre',$genres);           
        }

        if (!empty($years))
        {
            $query->where(function($q) use ($years) {
                foreach ($years as $year) {
                    $q->orWhereYear('release_date', $year);
                }
            });
        }

        $products =$query->get();

        return view('partials.catalogue',compact('products'))->render();
    }

    public function search(Request $request)
    {

        $searchTerm = $request->input('search');

        // Query products based on the search term
        $products = Product::where('name', 'LIKE', "%{$searchTerm}%")
                            ->get();


        return view('partials.catalogue',compact('products'))->render();
    }

    public function addcart(Request $request)
    {
        $productId = $request->game_id;
        $cartItem['productId'] = $productId;
        $quantity =$request->quantity;
        $product = Product::find($productId);
        if (!$product) {
            return redirect()->route('/')->with('error', 'Product not found!');
        }
        else
        {
            if(!empty(Sale::where('game_id',$productId)))
            {   
                $salesProduct=Sale::where('game_id',$productId)->first();
                $cartItem['price']= $salesProduct->new_price;
                $cartItem['productName']= $salesProduct->name;
                $cartItem['productQuantity'] = $quantity;
                $cartItem['image'] = $salesProduct->image;
            }
            else
            {
                $products = Product::where($productId)->first();
                $cartItem['price']= $products->price;
                $cartItem['productName']= $products->name;
                $cartItem['productQuantity'] =  $quantity;
                $cartItem['image'] = $products->image;
            }
        }
        
        if(Auth::check())
       {
            
            $userid =Auth::user()->uuid;
            $cartItem['uuid']= $userid;
            
       }
       else
       {
        $guestUuid = Cookie::get('guest_uuid');
        $cartItem['uuid']= $guestUuid;
       }
        Cart::create($cartItem);
        return redirect()->route('getCatalogue')->with('success', 'Product added to cart successfully!');
    
    }
}
