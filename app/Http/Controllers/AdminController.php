<?php

namespace App\Http\Controllers;

use App\Models\genre;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function addProduct()
    {
        $genres = genre::all();
        return view('products.createproduct',compact('genres'));
    }

    public function Products()
    {
        $all = Product::all();
        return view('products.Productoptions', compact('all'));
    }

    public function storeproduct(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'genre' => 'required|array',
            'genre.*' => 'string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'release_date' => 'required',
            'description' => 'required',
        ]);
        $imagename = $request->name . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $imagename);
        $product['name'] = $request->name;
        $product['price'] = $request->price;
        $product['genre'] = json_encode($request->genre);
        $product['image'] = 'images/' . $imagename;
        $product['release_date'] = $request->release_date;
        $product['description'] = $request->description;
        Product::create($product);
        return redirect()->route('welcome')->with('success', 'Product created successfully.');
    }

    public function update(Request $request)
    {

        $product = Product::findOrFail($request->requestid);

        if ($request->hasFile('image')) {
            // Handle image upload logic here
            $imagename = $request->name . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imagename);
            $product->image = 'images/' . $imagename;
        }

        // Update other fields
        $product->name = $request->name;
        $product->price = $request->price;
        $product->genre = $request->genre;
        $product->release_date = $request->release_date;
        $product->description = $request->description;

        $product->save();

        return redirect()->route('welcome')->with('success', 'Product updated successfully.');
    }
    public function search(Request $request)
    {

        $searchTerm = $request->input('search', '');

        // Query products based on the search term
        $all = Product::where('name', 'LIKE', "%{$searchTerm}%")
            ->get();


        return view('products.Productoptions', compact('all'))->render();
    }
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Optionally delete the image file from the server
        if ($product->image && file_exists(public_path($product->image))) {
            unlink(public_path($product->image)); // Delete old image
        }

        $product->delete();

        return redirect()->route('welcome')->with('success', 'Product deleted successfully.');
    }

    public function editsales()
    {

        $sales = Sale::all();
        $all = Product::all()->sortBy('name');

        return view('products.editsales', compact('sales', 'all'));
    }

    public function searchGames(Request $request)
    {
        $query = $request->input('query');

        // Perform search by game name
        $games = Product::where('name', 'like', "$query%")->get(['id', 'name']);  // Return only id and name

        // Return the matching games as JSON
        return response()->json($games);
    }


    public function getprices(Request $request)
    {
        $game = $request->input('game_id');
        $tgame = Product::where('name', $game)->first(['price']);

        return response()->json([
            'price' => $tgame->price
        ]);
    }


    public function addtosales(Request $request)
    {
        $game['name'] = $request->game_name;
        $game['game_id'] = $request->game_id;
        $game['old_price'] = $request->old_price;
        $game['new_price'] = $request->new_price;
        $imagename = $request->game_name . ' sale'.'.' . $request->image->extension();
        $request->image->move(public_path('images'), $imagename);
        $game['image'] = 'images/' . $imagename;
        Sale::create($game);
        $sales = Sale::all();
        $all = Product::all()->sortBy('name');
        return view('products.editsales', compact('sales', 'all'));

    }
}
