<?php

namespace App\Http\Controllers\Auth;

use App\Models\j_n_t;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Courier;

class ShippingController extends Controller
{

    // public function courier(){

    //     $courier = Courier::all();

    //     return response()->json($courier);
    // }

    public function select($id, $shipping_method, $postcode){

        $product = Product::findorFail($id);

        $weight = $product->weight;

        $postalcode = $product->branch()->first();

        $courier = Courier::findorFail($shipping_method);

        $price = $courier->rates()
        ->where('zip_from', $postalcode->postcode)
        ->where('zip_to', $postcode)
        ->where(function ($query) use ($weight) {
            $query->where('weight_from', '<=', $weight);
            $query->where('weight_to', '>=', $weight);
        })
        ->first()->price;

        return response()->json($price);

    }
}
