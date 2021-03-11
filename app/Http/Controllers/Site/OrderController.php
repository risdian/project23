<?php

namespace App\Http\Controllers\Site;

use Carbon\Carbon;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Contracts\OrderContract;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;

class OrderController extends BaseController
{
    protected $orderRepository;

    public function __construct(OrderContract $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function index($order_number){

        $order = Order::where('order_number', $order_number)->first();
        if($order === null){

            return 'this order not exist';

        }


        if($order->payment_status == 1 ) {
            $payment = 'Successful';
        } else {
            $payment ='Pending';
        }

                 //relation antara product dan order
        $trackings = DB::table('order_product')
                 ->join('products', 'products.id', 'order_product.product_id')
                 ->join('orders', 'orders.id', 'order_product.order_id')
                 ->join('branches', 'branches.id', 'products.branch_id')
                 ->where('orders.id', $order->id)
                 ->where('orders.payment_status', '1')
                 ->groupBy(['orders.order_number', 'products.branch_id'])
                 ->select('orders.id','products.branch_id','orders.order_number', DB::raw('count(order_product.product_id) as item'), 'orders.name', 'orders.phone_number', 'orders.address', 'orders.city','orders.state','orders.country', 'orders.postcode', 'branches.name as branch', 'branches.id as branch_id')
             ->get();

        $sni = Order::find($order->id);


        $result = collect($sni->products()->with('images','branch', 'category')->get())

            ->groupBy('branch.name')
            ->toArray();

        // return $result;



        return view('site.pages.order.show', compact('order', 'payment', 'trackings', 'result'));

    }

    public function tracking($order_number){

        $trackings = DB::table('order_product')
        ->join('products', 'products.id', 'order_product.product_id')
        ->join('orders', 'orders.id', 'order_product.order_id')
        ->join('branches', 'branches.id', 'products.branch_id')
        ->where('orders.order_number', $order_number)
        ->where('orders.payment_status', '1')
        ->groupBy(['orders.order_number', 'products.branch_id'])
        ->select('orders.id','products.branch_id','orders.order_number', DB::raw('count(order_product.product_id) as item'), 'orders.name', 'orders.phone_number', 'orders.address', 'orders.city','orders.state','orders.country', 'orders.postcode', 'branches.name as branch')
        ->get();

        return $trackings;
    }

    public function update_tracking(Request $request){


        $branch_id = $request->branch_id;

        $order = Order::
            with(
                array(
                    'products' => function($query) use ($branch_id) {
                        $query->where('branch_id', $branch_id);
                    },
                    'products.images',

            ))->find($request->id);

        foreach($order['products'] as $products){

            $order = DB::update('update order_product set tracking_status = ?, tracking_datetime=? where order_id = ? and product_id = ?',[
                $request->tracking_number,
                Carbon::now(),
                $request->id,
                $products->id,
            ]);

        }


    }
}
