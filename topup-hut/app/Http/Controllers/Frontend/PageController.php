<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show($slug)
    {
        $page = Page::where('slug', $slug)->first();
        
        if (!$page) {
            // Return 404 if page doesn't exist
            abort(404);
        }
        
        return view('frontend.page', compact('page'));
    }
}
