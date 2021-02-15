<?php

namespace App\Http\Controllers\Auth;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Contracts\OrderContract;
use App\Services\ToyyibPayService;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;

class OrderController extends BaseController
{
    protected $orderRepository;
    protected $toyyibPay;

    public function __construct(OrderContract $orderRepository, ToyyibPayService $toyyibPay)
    {
        $this->orderRepository = $orderRepository;
        $this->toyyibPay = $toyyibPay;
    }

    public function index(Request $request){

        $orders = Order::where('user_id', $request->user()->id)->get();

        return response()->json($orders);

    }

    public function store(Request $request){

        $this->validate($request, [
            'name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'postcode' => 'required',
            'phone_number' => 'required',
        ]);

        $order = $this->orderRepository->storeAppOrderDetails($request->all());

        $this->toyyibPay->processPayment($order);

        return response()->json($order);

    }

    public function view($id){

        $order = $this->orderRepository->findOrderById($id);

        return response()->json($order);

    }

    public function payment(Request $request){

        $this->validate($request, [
            'payment' => 'required',
        ]);

        $order = $this->orderRepository->updateAppOrderDetails($request->all());


        if (!$order) {
            return response()->json([
                'message' => 'Error occurred while updating order.'
            ], 201);
        }

        return response()->json([
            'message' => 'Order updated successfully',
            'toyyib'  => $order->payment_code,
        ], 201);

    }

    public function products($id){

        $order = Order::findOrFail($id)->products()->with('images')->get()->toArray();

        return response()->json($order);


    }

    public function placeOrder(Request $request)
    {
    //    return response()->json($request->product);

        // return 'aneer';
        // Before storing the order we should implement the
        // request validation which I leave it to you
        $order = $this->orderRepository->storeAppOrderDetails($request->all());

        return response()->json($order);


    }

}
