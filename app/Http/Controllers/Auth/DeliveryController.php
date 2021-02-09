<?php

namespace App\Http\Controllers\Auth;

use PDF;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Branch;

class DeliveryController extends Controller
{
    public function index(){

        if(Auth()->user()->status == 'sale_expert'){

        $products = DB::table('order_product')
            ->join('products', 'products.id', 'order_product.product_id')
            ->join('orders', 'orders.id', 'order_product.order_id')
            ->join('branches', 'branches.id', 'products.branch_id')
            ->where('products.user_id', Auth()->user()->id)
            ->where('orders.payment_status', '1')
            ->groupBy(['orders.order_number', 'products.branch_id'])
            ->select('orders.id','products.branch_id','orders.order_number', DB::raw('count(order_product.product_id) as item'), 'orders.name', 'orders.phone_number', 'orders.address', 'orders.city','orders.state','orders.country', 'orders.postcode', 'branches.name as branch')
            ->get();

        $productCount = DB::table('order_product')
            ->join('products', 'products.id', 'order_product.product_id')
            ->join('orders', 'orders.id', 'order_product.order_id')
            ->join('branches', 'branches.id', 'products.branch_id')
            ->where('products.user_id', Auth()->user()->id)
            ->where('orders.payment_status', '1')
            ->count();

        return response()->json([
            'products' => $products,
            'productCount' => $productCount,
        ]);

        }elseif(Auth()->user()->status == 'personal_shopper_1'){

         //relation antara product dan order
        $products = DB::table('order_product')
            ->join('products', 'products.id', 'order_product.product_id')
            ->join('orders', 'orders.id', 'order_product.order_id')
            ->join('branches', 'branches.id', 'products.branch_id')
            ->where('orders.user_id', Auth()->user()->id)
            ->where('orders.payment_status', '1')
            ->groupBy(['orders.order_number', 'products.branch_id'])
            ->select('orders.id','products.branch_id','orders.order_number', DB::raw('count(order_product.product_id) as item'), 'orders.name', 'orders.phone_number', 'orders.address', 'orders.city','orders.state','orders.country', 'orders.postcode', 'branches.name as branch')
        ->get();

        $productCount = DB::table('order_product')
            ->join('products', 'products.id', 'order_product.product_id')
            ->join('orders', 'orders.id', 'order_product.order_id')
            ->join('branches', 'branches.id', 'products.branch_id')
            ->where('orders.user_id', Auth()->user()->id)
            ->where('orders.payment_status', '1')
        ->count();

        $users = User::where('parent_id', Auth()->user()->id)->get();


        foreach($users as $user) {

            $orders[] =  $user->orders()->with('user')
                ->where('payment_status', '1')
                ->get();

        }
        if(!$users->isEmpty()){

            $new = [];
            while($order = array_shift($orders)){
                array_push($new, ...$order);
            }
            $countItem = count($new);

        }else{
            $new = [];
            $countItem = 0;
        }


        return response()->json([
            'products' => $products,
            'orders' => $new,
            'productCount' => $productCount,
            'countItem' => $countItem
        ]);

        }elseif(Auth()->user()->status == 'personal_shopper_2'){

            //relation antara product dan order
            $products = DB::table('order_product')
                ->join('products', 'products.id', 'order_product.product_id')
                ->join('orders', 'orders.id', 'order_product.order_id')
                ->join('branches', 'branches.id', 'products.branch_id')
                ->where('orders.user_id', Auth()->user()->id)
                ->where('orders.payment_status', '1')
                ->groupBy(['orders.order_number', 'products.branch_id'])
                ->select('orders.id','products.branch_id','orders.order_number', DB::raw('count(order_product.product_id) as item'), 'orders.name', 'orders.phone_number', 'orders.address', 'orders.city','orders.state','orders.country', 'orders.postcode', 'branches.name as branch')
                ->get();

            $productCount = DB::table('order_product')
                ->join('products', 'products.id', 'order_product.product_id')
                ->join('orders', 'orders.id', 'order_product.order_id')
                ->join('branches', 'branches.id', 'products.branch_id')
                ->where('orders.user_id', Auth()->user()->id)
                ->where('orders.payment_status', '1')
                ->count();

            return response()->json([
                'products' => $products,
                'productCount' => $productCount,
            ]);
        }


        // return response()->json($orders);
    }

    public function agent($id){
                 //relation antara product dan order
         //relation antara product dan order
         $products = DB::table('order_product')
         ->join('products', 'products.id', 'order_product.product_id')
         ->join('orders', 'orders.id', 'order_product.order_id')
         ->join('branches', 'branches.id', 'products.branch_id')
         ->where('orders.id', $id)
         ->where('orders.payment_status', '1')
         ->groupBy(['orders.order_number', 'products.branch_id'])
         ->select('orders.id','products.branch_id','orders.order_number', DB::raw('count(order_product.product_id) as item'), 'orders.name', 'orders.phone_number', 'orders.address', 'orders.city','orders.state','orders.country', 'orders.postcode', 'branches.name as branch')
     ->get();

     return response()->json($products);

    }

    public function edit($branch_id,$id){

        $order = Order::
            with(
                array(
                    'products' => function($query) use ($branch_id) {
                        $query->where('branch_id', $branch_id);
                    },
                    'products.images',
            ))
        ->find($id);


        return response()->json($order);
    }

    public function update(Request $request){

        $request->validate([

            'id'                =>  'required',
            'branch_id'         =>  'required',
            'tracking_number'   =>  'required',

        ]);

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

            $order = DB::update('update order_product set tracking_number = ?, tracking_datetime=? where order_id = ? and product_id = ?',[
                $request->tracking_number,
                Carbon::now(),
                $request->id,
                $products->id,
            ]);

        }


        if (!$order) {
            return response()->json([
                'message' => 'Error occurred while updating item.'
            ], 201);
        }

        return response()->json([
            'message' => 'Shipping tracking updated successfully',
        ], 201);
    }

    public function print($branch_id, $id){

        $order = Order::
            with(
                array(
                    'products' => function($query) use ($branch_id) {
                        $query->where('branch_id', $branch_id);
                    },
                    'products.images',
            ))
        ->find($id);

        $branch = Branch::findOrFail($branch_id);

        foreach($order->products as $product){

            $tracking =  $product->pivot->tracking_number;

        }


        $pdf = PDF::loadView('admin.orders.pdf_view', compact('order', 'branch', 'tracking'));

        return $pdf->stream('medium.pdf');

    }
}
