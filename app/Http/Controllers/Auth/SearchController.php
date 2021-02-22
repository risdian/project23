<?php

namespace App\Http\Controllers\Auth;

use App\Models\Item;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function product(Request $request){

            $search = $request->get('search');
            if(Auth()->user()->status == 'admin'){
                $products = Product::
                where('name', 'like', '%'.$search.'%')
                ->with('category', 'branch', 'images')
                ->get();
            }else{

                $products = Product::
                where('name', 'like', '%'.$search.'%')->where('user_id', Auth()->user()->id)
                ->with('category', 'branch', 'images')
                ->get();
            }


            return response()->json($products);

    }

    public function item_product(Request $request){

            $search = $request->get('search');

            $products = Product::
                where('name', 'like', '%'.$search.'%')
                ->with(
                    array('category', 'branch', 'images' ,'items' => function($query) {
                        $query->where('user_id', Auth()->user()->id);
                    })
                )
                ->get();

            return response()->json($products);

    }

    public function item(Request $request){

        $search = $request->get('search');

        // $products = Item::join('products', 'products.id', '=', 'items.product_id')
        //     ->where('items.user_id',  Auth()->user()->id)
        //     ->where('products.name', 'like', '%'.$search.'%')
        //     ->with('product')->get();


        $products = Product::whereIn('id',
            Item::select('product_id')
            ->where('user_id', Auth()->user()->id)
            ->get())->where('name', 'like', '%'.$search.'%')
            ->with('category', 'branch', 'images')
            ->get();

        // $products = Product::
        // where('name', 'like', '%'.$search.'%')
        // ->with('category', 'branch', 'images')->get();

        return response()->json($products);

}

    public function order(Request $request){

        $search = $request->get('search');

        $orders = Order::where(function ($query) use ($search) {

            $query->where('name', 'like', '%'.$search.'%')->where('parent_id', Auth()->user()->id);
            })
            ->orwhere(function ($query) use ($search) {

                $query->where('email', 'like', '%'.$search.'%')->where('parent_id', Auth()->user()->id);
            })
            ->orwhere(function ($query) use ($search) {

                $query->where('phone_number', 'like', '%'.$search.'%')->where('parent_id', Auth()->user()->id);
            })
            ->orwhere(function ($query) use ($search) {

                $query->where('order_number', 'like', '%'.$search.'%')->where('parent_id', Auth()->user()->id);
            })
            ->orwhere(function ($query) use ($search) {

                $query->where('address', 'like', '%'.$search.'%')->where('parent_id', Auth()->user()->id);
            })
            ->orwhere(function ($query) use ($search) {

                $query->where('postcode', 'like', '%'.$search.'%')->where('parent_id', Auth()->user()->id);
            })
            ->orwhere(function ($query) use ($search) {

                $query->where('state', 'like', '%'.$search.'%')->where('parent_id', Auth()->user()->id);
            })
            ->orderBy('updated_at', 'DESC')->get();


        return response()->json($orders);

    }

    public function invite(Request $request){
        $search = $request->get('search');

        $invite = User::where(function ($query) use ($search) {

                $query->where('name', 'like', '%'.$search.'%')->where('parent_id', Auth()->user()->id);
            })
            ->orwhere(function ($query) use ($search) {

                $query->where('email', 'like', '%'.$search.'%')->where('parent_id', Auth()->user()->id);
            })
            ->orwhere(function ($query) use ($search) {

                $query->where('mobile', 'like', '%'.$search.'%')->where('parent_id', Auth()->user()->id);
            })

            ->get();

        return response()->json($invite);

    }
}
