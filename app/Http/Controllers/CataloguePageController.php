<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Review;
use App\Models\Sale;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class CataloguePageController extends Controller
{
    public function getItem($id)
    {
        $item = Product::where('id',$id)->get()->first();
        $reviews = Review::where('product_id',$id)->get();
        $rating = Review::where('product_id',$id)->avg('rating');
        return view('catalogue.item',compact(['item','reviews','rating']));
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

    
}
