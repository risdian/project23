<?php

namespace App\Http\Controllers\Site;

use Cart;
use Carbon\Carbon;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Contracts\OrderContract;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;

class CheckoutController extends BaseController
{

    protected $orderRepository;

    public function __construct(OrderContract $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function getCheckout()
    {
        return view('site.pages.checkout');
    }

    public function placeOrder(Request $request)
    {
        // Before storing the order we should implement the
        // request validation which I leave it to you
        $order = $this->orderRepository->storeOrderDetails($request->all());

        // You can add more control here to handle if the order is not stored properly
        if ($order) {
        }

        return redirect()->back()->with('message','Order not placed');
    }

    public function complete(Request $request)
    {
        $order = $this->orderRepository->findOrderByNumber($request->order_id);

        if($request->status_id == 1){

            $order->status = 'processing';
            $order->payment_status = $request->status_id;
            $order->payment_transaction_id = $request->transaction_id;
            $order->payment_datetime = Carbon::now();

        }else{

            $order->payment_status = $request->status_id;
            $order->payment_transaction_id = $request->transaction_id;
            $order->payment_datetime = Carbon::now();
        }

        $order->save();

        return redirect()->route('orders.selamat',['order_number' => $order->order_number]);
    }

    public function order($order_number){

        $order = $this->orderRepository->findOrderByNumber($order_number);

        $products = $order->products;

        $this->setPageTitle($order->order_number, 'List of all items');

        return view('site.pages.success', compact('order', 'products'));

    }
}
