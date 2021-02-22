<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Contracts\OrderContract;
use App\Services\ToyyibPayService;
use Illuminate\Support\Facades\DB;
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

        $orders = Order::where('user_id', $request->user()->id)->orderBy('updated_at', 'DESC')->get();

        return response()->json($orders);

    }

    public function agent(Request $request){

        $orders = Order::where('user_id', $request->user()->id)->orderBy('updated_at', 'DESC')->get();

        $orderCounts = Collect($orders)->count();

        return response()->json([
            'orders'        => $orders,
            'orderCounts'   => $orderCounts,
        ]);

    }

    public function agent_search(Request $request){

        $search = $request->get('search');

        $orders = Order::where(function ($query) use ($search) {

                $query->where('order_number', 'like', '%'.$search.'%')->where('user_id', Auth()->user()->id);
            })
            ->orWhere(function ($query) use ($search) {

                $query->where('name', 'like', '%'.$search.'%')->where('user_id', Auth()->user()->id);
            })
            ->orWhere(function ($query) use ($search) {

                $query->where('phone_number', 'like', '%'.$search.'%')->where('user_id', Auth()->user()->id);
            })
            ->orWhere(function ($query) use ($search) {

                $query->where('email', 'like', '%'.$search.'%')->where('user_id', Auth()->user()->id);
            })
            ->orWhere(function ($query) use ($search) {

                $query->where('address', 'like', '%'.$search.'%')->where('user_id', Auth()->user()->id);
            })
            ->orWhere(function ($query) use ($search) {

                $query->where('postcode', 'like', '%'.$search.'%')->where('user_id', Auth()->user()->id);
            })
            ->orWhere(function ($query) use ($search) {

                $query->where('city', 'like', '%'.$search.'%')->where('user_id', Auth()->user()->id);
            })
            ->orWhere(function ($query) use ($search) {

                $query->where('state', 'like', '%'.$search.'%')->where('user_id', Auth()->user()->id);
            })
            ->orWhere(function ($query) use ($search) {

                $query->where('country', 'like', '%'.$search.'%')->where('user_id', Auth()->user()->id);
            })
            ->orWhere(function ($query) use ($search) {

                $query->where('status', 'like', '%'.$search.'%')->where('user_id', Auth()->user()->id);
            })
            ->orderBy('updated_at', 'DESC')
            ->get();

        return response()->json($orders);

    }


    public function personal_shopper(Request $request){

        $orders = Order::where('user_id', $request->user()->id)->orderBy('updated_at', 'DESC')->get();

        $users = User::where('parent_id', Auth()->user()->id)->pluck('id')->toArray();

        $itemOrders = Order::whereIn('user_id', $users)->with('user')->orderBy('updated_at', 'DESC')->get();

        $orderCounts = Collect($orders)->count();
        $itemCounts = Collect($itemOrders)->count();

        return response()->json([
            'itemCounts'    => $itemCounts,
            'orders'        => $orders,
            'itemOrders'    => $itemOrders,
            'orderCounts'   => $orderCounts,
        ]);

    }

    public function personal_shopper_search(Request $request){

        $search = $request->get('search');

        $orders = Order::where(function ($query) use ($search) {

                $query->where('order_number', 'like', '%'.$search.'%')->where('user_id', Auth()->user()->id);
            })
            ->orWhere(function ($query) use ($search) {

                $query->where('name', 'like', '%'.$search.'%')->where('user_id', Auth()->user()->id);
            })
            ->orWhere(function ($query) use ($search) {

                $query->where('phone_number', 'like', '%'.$search.'%')->where('user_id', Auth()->user()->id);
            })
            ->orWhere(function ($query) use ($search) {

                $query->where('email', 'like', '%'.$search.'%')->where('user_id', Auth()->user()->id);
            })
            ->orWhere(function ($query) use ($search) {

                $query->where('address', 'like', '%'.$search.'%')->where('user_id', Auth()->user()->id);
            })
            ->orWhere(function ($query) use ($search) {

                $query->where('postcode', 'like', '%'.$search.'%')->where('user_id', Auth()->user()->id);
            })
            ->orWhere(function ($query) use ($search) {

                $query->where('city', 'like', '%'.$search.'%')->where('user_id', Auth()->user()->id);
            })
            ->orWhere(function ($query) use ($search) {

                $query->where('state', 'like', '%'.$search.'%')->where('user_id', Auth()->user()->id);
            })
            ->orWhere(function ($query) use ($search) {

                $query->where('country', 'like', '%'.$search.'%')->where('user_id', Auth()->user()->id);
            })
            ->orWhere(function ($query) use ($search) {

                $query->where('status', 'like', '%'.$search.'%')->where('user_id', Auth()->user()->id);
            })
            ->orderBy('updated_at', 'DESC')
            ->get();

        return response()->json($orders);

    }

    public function personal_shopper_search_agent(Request $request){

        $search = $request->get('search');

        $users = User::where('parent_id', Auth()->user()->id)->pluck('id')->toArray();

        $itemOrders = Order::where(function ($query) use ($search, $users) {

                $query->where('order_number', 'like', '%'.$search.'%')->whereIn('user_id', $users);
            })
            ->orWhere(function ($query) use ($search, $users) {

                $query->where('name', 'like', '%'.$search.'%')->whereIn('user_id', $users);
            })
            ->orWhere(function ($query) use ($search, $users) {

                $query->where('phone_number', 'like', '%'.$search.'%')->whereIn('user_id', $users);
            })
            ->orWhere(function ($query) use ($search, $users) {

                $query->where('email', 'like', '%'.$search.'%')->whereIn('user_id', $users);
            })
            ->orWhere(function ($query) use ($search, $users) {

                $query->where('address', 'like', '%'.$search.'%')->whereIn('user_id', $users);
            })
            ->orWhere(function ($query) use ($search, $users) {

                $query->where('postcode', 'like', '%'.$search.'%')->whereIn('user_id', $users);
            })
            ->orWhere(function ($query) use ($search, $users) {

                $query->where('city', 'like', '%'.$search.'%')->whereIn('user_id', $users);
            })
            ->orWhere(function ($query) use ($search, $users) {

                $query->where('state', 'like', '%'.$search.'%')->whereIn('user_id', $users);
            })
            ->orWhere(function ($query) use ($search, $users) {

                $query->where('country', 'like', '%'.$search.'%')->whereIn('user_id', $users);
            })
            ->orWhere(function ($query) use ($search, $users) {

                $query->where('status', 'like', '%'.$search.'%')->whereIn('user_id', $users);
            })
            ->with('user')->orderBy('updated_at', 'DESC')
            ->get();

        return response()->json($itemOrders);

    }

    public function sale_expert(Request $request){

        $orders = Order::where('user_id', $request->user()->id)->orderBy('updated_at', 'DESC')->get();

        $itemOrders = DB::table('order_product')
        ->join('products', 'products.id', 'order_product.product_id')
        ->join('orders', 'orders.id', 'order_product.order_id')
        ->join('branches', 'branches.id', 'products.branch_id')
        ->join('users', 'users.id', 'orders.user_id')
        ->where('products.user_id', Auth()->user()->id)
        ->where('orders.user_id','!=', Auth()->user()->id)
        ->groupBy(['orders.order_number', 'products.branch_id'])
        ->orderBy('orders.updated_at', 'DESC')
        ->select('orders.id','products.branch_id','orders.order_number', DB::raw('count(order_product.product_id) as item'), 'orders.name', 'orders.phone_number', 'orders.address', 'orders.city','orders.state','orders.country', 'orders.postcode', 'branches.name as branch', 'orders.status', 'orders.payment_status', 'orders.updated_at','users.name as username')
        ->get();

        $orderCounts = Order::where('user_id', $request->user()->id)->orderBy('updated_at', 'DESC')->count();

        $itemCounts = Collect($itemOrders)->count();

        return response()->json([
            'itemCounts'    => $itemCounts,
            'orders'        => $orders,
            'itemOrders'    => $itemOrders,
            'orderCounts'   => $orderCounts,

        ]);

    }

    public function sale_expert_search(Request $request){

        $search = $request->get('search');

        $orders = Order::where(function ($query) use ($search) {

                $query->where('order_number', 'like', '%'.$search.'%')->where('user_id', Auth()->user()->id);
            })
            ->orWhere(function ($query) use ($search) {

                $query->where('name', 'like', '%'.$search.'%')->where('user_id', Auth()->user()->id);
            })
            ->orWhere(function ($query) use ($search) {

                $query->where('phone_number', 'like', '%'.$search.'%')->where('user_id', Auth()->user()->id);
            })
            ->orWhere(function ($query) use ($search) {

                $query->where('email', 'like', '%'.$search.'%')->where('user_id', Auth()->user()->id);
            })
            ->orWhere(function ($query) use ($search) {

                $query->where('address', 'like', '%'.$search.'%')->where('user_id', Auth()->user()->id);
            })
            ->orWhere(function ($query) use ($search) {

                $query->where('postcode', 'like', '%'.$search.'%')->where('user_id', Auth()->user()->id);
            })
            ->orWhere(function ($query) use ($search) {

                $query->where('city', 'like', '%'.$search.'%')->where('user_id', Auth()->user()->id);
            })
            ->orWhere(function ($query) use ($search) {

                $query->where('state', 'like', '%'.$search.'%')->where('user_id', Auth()->user()->id);
            })
            ->orWhere(function ($query) use ($search) {

                $query->where('country', 'like', '%'.$search.'%')->where('user_id', Auth()->user()->id);
            })
            ->orWhere(function ($query) use ($search) {

                $query->where('status', 'like', '%'.$search.'%')->where('user_id', Auth()->user()->id);
            })
            ->orderBy('updated_at', 'DESC')->get();

        return response()->json($orders);

    }

    public function sale_expert_search_agent(Request $request){

        $search = $request->get('search');

        $orders = DB::table('order_product')
            ->join('products', 'products.id', 'order_product.product_id')
            ->join('orders', 'orders.id', 'order_product.order_id')
            ->join('branches', 'branches.id', 'products.branch_id')
            ->join('users', 'users.id', 'orders.user_id')

            ->where(function ($query) use ($search) {

                $query->where('products.user_id', Auth()->user()->id)
                ->where('orders.user_id','!=', Auth()->user()->id)
                ->where('order_number', 'like', '%'.$search.'%');
            })
            ->orWhere(function ($query) use ($search) {

                $query->where('products.user_id', Auth()->user()->id)
                ->where('orders.user_id','!=', Auth()->user()->id)
                ->where('orders.name', 'like', '%'.$search.'%');
            })
            ->orWhere(function ($query) use ($search) {

                $query->where('products.user_id', Auth()->user()->id)
                ->where('orders.user_id','!=', Auth()->user()->id)
                ->where('orders.status', 'like', '%'.$search.'%');
            })
            ->orWhere(function ($query) use ($search) {

                $query->where('products.user_id', Auth()->user()->id)
                ->where('orders.user_id','!=', Auth()->user()->id)
                ->where('orders.phone_number', 'like', '%'.$search.'%');
            })
            ->orWhere(function ($query) use ($search) {

                $query->where('products.user_id', Auth()->user()->id)
                ->where('orders.user_id','!=', Auth()->user()->id)
                ->where('orders.email', 'like', '%'.$search.'%');
            })
            ->orWhere(function ($query) use ($search) {

                $query->where('products.user_id', Auth()->user()->id)
                ->where('orders.user_id','!=', Auth()->user()->id)
                ->where('orders.address', 'like', '%'.$search.'%');
            })
            ->orWhere(function ($query) use ($search) {

                $query->where('products.user_id', Auth()->user()->id)
                ->where('orders.user_id','!=', Auth()->user()->id)
                ->where('orders.postcode', 'like', '%'.$search.'%');
            })
            ->orWhere(function ($query) use ($search) {

                $query->where('products.user_id', Auth()->user()->id)
                ->where('orders.user_id','!=', Auth()->user()->id)
                ->where('orders.state', 'like', '%'.$search.'%');
            })
            ->orWhere(function ($query) use ($search) {

                $query->where('products.user_id', Auth()->user()->id)
                ->where('orders.user_id','!=', Auth()->user()->id)
                ->where('orders.country', 'like', '%'.$search.'%');
            })
            ->orWhere(function ($query) use ($search) {

                $query->where('products.user_id', Auth()->user()->id)
                ->where('orders.user_id','!=', Auth()->user()->id)
                ->where('branches.name', 'like', '%'.$search.'%');
            })
            ->orWhere(function ($query) use ($search) {

                $query->where('products.user_id', Auth()->user()->id)
                ->where('orders.user_id','!=', Auth()->user()->id)
                ->where('orders.updated_at', 'like', '%'.$search.'%');
            })

            ->groupBy(['orders.order_number', 'products.branch_id'])
            ->orderBy('orders.updated_at', 'DESC')
            ->select('orders.id','products.branch_id','orders.order_number', DB::raw('count(order_product.product_id) as item'), 'orders.name', 'orders.phone_number', 'orders.address', 'orders.city','orders.state','orders.country', 'orders.postcode', 'branches.name as branch', 'orders.status', 'orders.payment_status', 'orders.updated_at','users.name as username')
            ->get();

            return response()->json($orders);
    }

    public function store(Request $request){

        $this->validate($request, [
            'name'              => 'required|string|min:5|max:255',
            'address'           => 'required|string|min:5|max:255',
            'email'             => 'nullable|email',
            'city'              => 'required|string|min:5|max:255',
            'state'             => 'required|string|min:5|max:255',
            'country'           => 'required|string|min:5|max:255',
            'postcode'          => 'required|digits_between:5,8',
            'phone_number'      => 'required|regex:/^(\+?6?01)[0-46-9]-*[0-9]{7,8}$/',
            'delivery_method'   => 'required',
            'delivery_price'    => 'required|regex:/^\d+(\.\d{1,2})?$/',

        ]);

        $order = $this->orderRepository->storeAppOrderDetails($request->all());

        $this->toyyibPay->processPayment($order);

        return response()->json($order);

    }

    public function view($id){

        $order = $this->orderRepository->findOrderById($id);

        return response()->json($order);

    }

    public function view_sale_expert($id){

        $order = Order::
        with(
            array(
                'products' => function($query) {
                    $query->where('user_id', Auth()->user()->id);
                },
                'products.images',
            ))
        ->find($id);

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
