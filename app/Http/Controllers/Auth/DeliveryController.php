<?php

namespace App\Http\Controllers\Auth;

use PDF;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DeliveryController extends Controller
{
    public function index(){

        //relation antara product dan order

        $products = DB::table('order_product')
            ->join('products', 'products.id', 'order_product.product_id')
            ->join('orders', 'orders.id', 'order_product.order_id')
            ->where('orders.user_id', Auth()->user()->id)
            ->where('orders.payment_status', '1')
        ->get();


        return response()->json($products);

        // $products = Order::where('products.branch_id',  )

    }

    public function edit($id){

        $products = DB::table('order_product')->where('id', $id)->first();

        return response()->json($products);
    }

    public function update(Request $request){

        $order = DB::update('update order_product set tracking_number = ?, tracking_datetime=? where id = ?',[
            $request->tracking_number,
            Carbon::now(),
            $request->id
        ]);

        if (!$order) {
            return response()->json([
                'message' => 'Error occurred while updating item.'
            ], 201);
        }

        return response()->json([
            'message' => 'Item updated successfully',
        ], 201);
    }

    public function print($id){

        $item = DB::table('order_product')->where('id', $id)->first();
        $order = Order::find($item->id);

        // $order = Order::with(['products.product'])->findOrFail($id);
        // $customPaper = array(0,0,419.53,595.28);
        $pdf = PDF::loadView('admin.orders.pdf_view', compact('order'));

        return $pdf->stream('medium.pdf');

        // return response()->json($order);
    }
}
