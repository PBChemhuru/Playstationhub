<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function postReview(Request $request)
    {
        $review = $request->validate([
            'product_id' => 'required|integer',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:500',
        ]);
        
        $review['uuid'] = Auth::user()->uuid;
        
        Review::create($review);
        
        return redirect()->back()->with('success', 'Review added');   
        //dont forget to  added verifed purchaser when you finish fixing the profile
    }
}
