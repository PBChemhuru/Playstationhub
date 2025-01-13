<?php

namespace App\Http\Controllers;

use App\Models\genre;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;

class WelcomePageController extends Controller
{
    public function welcome()
    {   

        $sales = Sale::all();
        return view('welcome', compact('sales'));
    }

    public function hotsales()
    {
        $sales = Sale::all();
        return view('products.sales', compact('sales'));
    }
    public function showByGenre($genres)
    {
        $games = Product::where('genre', 'LIKE', '%' . $genres . '%')->get();

        return view('genre.gamesByGenre', compact('games', 'genres'));
    }


    public function getCatalogue()
    {
        $all = Product::all()->sortBy('name');
        $genre =  Product::all()->select('genre')->groupBy('genre');
        $year =  Product::selectRaw('YEAR(release_date) as year')
            ->groupBy('year')
            ->get();
        return view('catalogue.catalogue', compact('all', 'genre', 'year'));
    }

    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }


    public function getcontactform()
    {
        return view('contactusform');
    }
}
