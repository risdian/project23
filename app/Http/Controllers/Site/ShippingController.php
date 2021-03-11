<?php

namespace App\Http\Controllers\Site;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
                    'products.branch',
            ))
        ->where('order_number', $order_number)->first();

        // return $order;

        return view('site.pages.shippings.view', compact('order'));
    }

    public function update($tracking_number, $id){


        $order = DB::update('update order_product set tracking_status = ? where tracking_number = ?  and order_id = ?',[
            'received',
            $tracking_number,
            $id,
        ]);


        $order = Order::find($id);

        foreach ($order->products as $product)
        {
            $aneer[] =  $product->pivot->tracking_status;
        }
        $jom = collect($aneer);

        if($jom->contains('')){

            return redirect()->back();

        }else{

            $order->status = 'completed';
            $order->save();
            return redirect()->back();
        }





    }
}
