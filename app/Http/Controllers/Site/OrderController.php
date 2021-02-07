<?php

namespace App\Http\Controllers\Site;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Contracts\OrderContract;
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

        // $order = $this->orderRepository->findOrderByNumber($order_number);

        $products = $order->products;


        return view('site.pages.order.show', compact('order', 'products'));

    }
}
