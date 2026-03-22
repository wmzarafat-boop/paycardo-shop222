<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::published()->with('primaryImage', 'category');

        if ($request->category) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $categoryIds = $category->children->pluck('id')->toArray();
                $categoryIds[] = $category->id;
                $query->whereIn('category_id', $categoryIds);
            }
        }

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->latest()->paginate(12);
        $categories = Category::whereNull('parent_id')->active()->get();

        return view('frontend.shop', compact('products', 'categories'));
    }

    public function search(Request $request)
    {
        $products = Product::published()
            ->where('name', 'like', '%' . $request->q . '%')
            ->with('primaryImage')
            ->paginate(12);

        return view('frontend.shop', compact('products'))->with('searchQuery', $request->q);
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $categoryIds = $category->children->pluck('id')->toArray();
        $categoryIds[] = $category->id;

        $products = Product::published()
            ->whereIn('category_id', $categoryIds)
            ->with('primaryImage')
            ->latest()
            ->paginate(12);

        $categories = Category::whereNull('parent_id')->active()->get();

        return view('frontend.shop', compact('products', 'categories', 'category'));
    }
}
