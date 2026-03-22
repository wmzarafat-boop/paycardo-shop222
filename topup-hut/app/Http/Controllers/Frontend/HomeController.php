<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredCategories = Category::featured()->whereNull('parent_id')->take(6)->get();
        $featuredProducts = Product::featured()->published()->with('primaryImage')->take(8)->get();
        $trendingProducts = Product::trending()->published()->with('primaryImage')->take(8)->get();
        $newProducts = Product::published()->with('primaryImage')->latest()->take(12)->get();

        $categories = Category::whereNull('parent_id')->active()->get();

        return view('frontend.home', compact(
            'featuredCategories',
            'featuredProducts',
            'trendingProducts',
            'newProducts',
            'categories'
        ));
    }
}
