<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Status;
use Auth;

class StaticPageController extends Controller
{
    public function home()
    {
        $feed_items = [];
        if (Auth::check()) {
            $feed_items = Auth::user()->feed()->paginate(30);
        }
        
        return view('static_pages/home', compact('feed_items'));
    }
//     public function home()
//     {
//         return view('static_pages/home');
//     }
    
    public function help()
    {
        return view('static_pages/help');
    }
    
    public function about()
    {
        return view('static_pages/about');
    }
}
