<?php

namespace App\Http\Controllers\Site;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShippingController extends Controller
{
    public function index($branch_id, $order_number){


        $order = Order::
            with(
                array(
                    'products' => function($query) use ($branch_id) {
                        $query->where('branch_id', $branch_id);
                    },
                    'products.images',
            ))
        ->where('order_number', $order_number)->first();

        // return $order;

        return view('site.pages.shippings.view', compact('order'));
    }
}
