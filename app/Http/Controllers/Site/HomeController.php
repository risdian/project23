<?php

namespace App\Http\Controllers\Site;

use App\Models\Item;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index(){

        $items = Product::whereIn('id',
        Item::select('product_id')->get()
        )->with('category', 'branch', 'images')
        ->get();

        return view('site.pages.homepage', compact('items'));
    }
}
