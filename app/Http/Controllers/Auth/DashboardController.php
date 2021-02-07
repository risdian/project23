<?php

namespace App\Http\Controllers\Auth;

use DateTime;
use Carbon\Carbon;
use App\Models\Item;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function sales(){

        // tomorrow -1 week returns tomorrow's 00:00:00 minus 7 days
        // you may want to come up with your own date tho
        $date = new DateTime('tomorrow -1 week');

        $this_year_grand_total =  Order::where('user_id', Auth()->user()->id)
            ->where('payment_status', 1)
            ->whereYear('payment_datetime', date('Y', strtotime('now')))
            ->sum('grand_total');

        $last_year_grand_total =  Order::where('user_id', Auth()->user()->id)
            ->where('payment_status', 1)
            ->whereYear('payment_datetime', date('Y', strtotime('-1 year')))
            ->sum('grand_total');


        $today_grand_total = Order::where('user_id', Auth()->user()->id)
            ->where('payment_status', 1)
            ->whereDate( 'payment_datetime', date('Y-m-d',strtotime("now")))
            ->sum('grand_total');

        $yesterday_grand_total = Order::where('user_id', Auth()->user()->id)
            ->where('payment_status', 1)
            ->whereDate( 'payment_datetime', date('Y-m-d',strtotime("-1 days")))
            ->sum('grand_total');

        $this_year_sub_total =  Order::where('user_id', Auth()->user()->id)
            ->where('payment_status', 1)
            ->whereYear('payment_datetime', date('Y', strtotime('now')))
            ->sum('sub_total');

        $last_year_sub_total =  Order::where('user_id', Auth()->user()->id)
            ->where('payment_status', 1)
            ->whereYear('payment_datetime', date('Y', strtotime('-1 year')))
            ->sum('sub_total');

        $today_sub_total = Order::where('user_id', Auth()->user()->id)
            ->where('payment_status', 1)
            ->whereDate( 'payment_datetime', date('Y-m-d',strtotime("now")))
            ->sum('sub_total');

        $yesterday_sub_total = Order::where('user_id', Auth()->user()->id)
            ->where('payment_status', 1)
            ->whereDate( 'payment_datetime', date('Y-m-d',strtotime("-1 days")))
            ->sum('sub_total');

        // DATE(objecttime) turns it into a 'YYYY-MM-DD' string
        // records are then grouped by that string
        $daily_sale_grand_total = Order::where('user_id', Auth()->user()->id)
            ->where('payment_status', 1)
            ->where('payment_datetime', '>', $date)
            ->groupBy('date')
            ->orderBy('date', 'DESC') // or ASC
            ->get(array(
                DB::raw('DATE(`payment_datetime`) AS `date`'),
                DB::raw('COUNT(*) as `count`'),
                DB::raw('SUM(`grand_total`) as `total`')
            ));

        $daily_sale_sub_total = Order::where('user_id', Auth()->user()->id)
            ->where('payment_status', 1)
            ->where('payment_datetime', '>', $date)
            ->groupBy('date')
            ->orderBy('date', 'DESC') // or ASC
            ->get(array(
                DB::raw('DATE(`payment_datetime`) AS `date`'),
                DB::raw('COUNT(*) as `count`'),
                DB::raw('SUM(`sub_total`) as `total`')
            ));

        $daily_sale_sum_sub_total = Order::where('user_id', Auth()->user()->id)->where('payment_status', 1)->where('payment_datetime', '>', $date)->sum('sub_total');

        $daily_sale_sum_grand_total = Order::where('user_id', Auth()->user()->id)->where('payment_datetime', '>', $date)->sum('grand_total');

        $daily_sale_count_sub_total = Order::where('user_id', Auth()->user()->id)->where('payment_status', 1)->where('payment_datetime', '>', $date)->count();

        $daily_sale_count_grand_total = Order::where('user_id', Auth()->user()->id)->where('payment_datetime', '>', $date)->count();

        $this_year = date('Y', strtotime('now'));
        $last_year = date('Y', strtotime('-1 year'));

        $this_month = date('M', strtotime('now'));
        $last_month = date('M', strtotime('-1 month'));

        $dateLast = Carbon::now()->startOfMonth();
        $dateNow = Carbon::now()->endOfMonth();
        $dateOldS = Carbon::now()->startOfMonth()->subMonth(1);
        $dateOldE = Carbon::now()->endOfMonth()->subMonth(1);

        $this_month_grand_total = Order::where('user_id', Auth()->user()->id)
            ->where('payment_status', 1)
            ->whereBetween('payment_datetime',[$dateLast,$dateNow])
            ->sum('grand_total');

        $last_month_grand_total = Order::where('user_id', Auth()->user()->id)
            ->where('payment_status', 1)
            ->whereBetween( 'payment_datetime', [$dateOldS,$dateOldE])
            ->sum('grand_total');

        $this_month_sub_total = Order::where('user_id', Auth()->user()->id)
            ->where('payment_status', 1)
            ->whereBetween('payment_datetime',[$dateLast,$dateNow])
            ->sum('sub_total');

        $last_month_sub_total = Order::where('user_id', Auth()->user()->id)
            ->where('payment_status', 1)
            ->whereBetween( 'payment_datetime', [$dateOldS,$dateOldE])
            ->sum('sub_total');


        $this_month_commission = config('settings.personal_shopper_tier_1') / 100 * $this_month_sub_total;
        $last_month_commission = config('settings.personal_shopper_tier_1') / 100 * $last_month_sub_total;

        $this_year_commission = config('settings.personal_shopper_tier_1') / 100 * $this_year_sub_total;
        $last_year_commission = config('settings.personal_shopper_tier_1') / 100 * $last_year_sub_total;

        $today_commission = config('settings.personal_shopper_tier_1') / 100 * $today_sub_total;
        $yesterday_commission = config('settings.personal_shopper_tier_1') / 100 * $yesterday_sub_total;


        // $personal_shopper_commission =

        // array('category', 'branch', 'images' ,'items' => function($query) {
        //     $query->where('user_id', Auth()->user()->id);


        // $order_item = Order::with(
        //     array('products' => function($query) {
        //         $query->where('user_id', Auth()->user()->id);
        //         })
        //     )
        //     ->get();



        // $user = Auth()->user();


        // return $user->products()->get();


            // ->sum('pivot.price');

        // $order_item->pivot;

            // $product = Product::with(
            //     array('category', 'branch', 'images' ,'items' => function($query) {
            //     $query->where('user_id', Auth()->user()->id);
            // })
            // )->find($id);
            // return response()->json($product);

        // return $user;

        // $order_item = DB::table('order_product')
        // ->join('products', 'order_product.product_id', '=', 'products.id')
        // ->join('orders', 'order_product.order_id', '=', 'orders.id')
        // ->where('products.user_id', '=', Auth()->user()->id)

        // // ->where('payment_status', 1)
        // // ->whereDate( 'payment_datetime', date('Y-m-d',strtotime("now")))

        // ->select('orders.order_number')
        // ->groupBy('orders.order_number')
        // ->get();


        /**
         * Sale Expert commission (daily)
        */
        $order_item = DB::table('order_product')
        ->join('products', 'order_product.product_id', '=', 'products.id')
        ->join('orders', 'order_product.order_id', '=', 'orders.id')
        ->where('products.user_id', '=', Auth()->user()->id)
        ->where('orders.status', 'completed')
        ->where('orders.payment_status', 1)
        ->whereBetween('orders.updated_at',[$dateLast,$dateNow])
        // ->whereDate( 'orders.payment_datetime', date('Y-m-d',strtotime("now")))
        ->select('order_product.*', 'products.user_id', 'orders.order_number')
        ->sum(DB::raw('order_product.price * order_product.quantity'));

        if($order_item >= 2000 && $order_item <= 2999){
            $total_commission = (10 / 100) * $order_item;
        }
        elseif($order_item >= 3000 && $order_item <= 3999){
            $total_commission = (20 / 100) * $order_item;
        }
        elseif($order_item >= 4000 && $order_item <= 5999){
            $total_commission = (30 / 100) * $order_item;
        }else{
            $total_commission = (10 / 100) * $order_item;


        }

        // return $total_commission;

        /**
         * Personal shopper 1 commission from ps 2
         * 2%
         */
        $user_today = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->where('users.parent_id', Auth()->user()->id)
            ->where('orders.status', 'completed')
            ->where('orders.payment_status', 1)
            ->whereDate( 'orders.payment_datetime', date('Y-m-d',strtotime("now")))
            ->sum('orders.sub_total');

        $total_ps2 = (2 / 100) * $user_today;

        // return $total_ps2;





        return response()->json([
            // 'last_year_grand_total'         =>      $last_year_grand_total,
            // 'this_year_grand_total'         =>      $this_year_grand_total,
            // 'yesterday_grand_total'         =>      $yesterday_grand_total,
            // 'today_grand_total'             =>      $today_grand_total,
            // 'last_year_sub_total'           =>      $last_year_sub_total,
            // 'this_year_sub_total'           =>      $this_year_sub_total,
            // 'yesterday_sub_total'           =>      $yesterday_sub_total,
            // 'today_sub_total'               =>      $today_sub_total,
            // 'daily_sale_sum_sub_total'      =>      $daily_sale_sum_sub_total,
            // 'daily_sale_sum_grand_total'    =>      $daily_sale_sum_grand_total,
            // 'daily_sale_count_sub_total'    =>      $daily_sale_count_sub_total,
            // 'daily_sale_count_grand_total'  =>      $daily_sale_count_grand_total,
            // 'daily_sale_sub_total'          =>      $daily_sale_sub_total,
            // 'daily_sale_grand_total'        =>      $daily_sale_grand_total,
            // 'this_year'                     =>      $this_year,
            // 'last_year'                     =>      $last_year,
            // 'this_month'                    =>      $this_month,
            // 'last_month'                    =>      $last_month,
            // 'this_month_grand_total'        =>      $this_month_grand_total,
            // 'last_month_grand_total'        =>      $last_month_grand_total,
            // 'this_month_sub_total'          =>      $this_month_sub_total,
            // 'last_month_sub_total'          =>      $last_month_sub_total,

            // 'this_month_commission'         =>      $this_month_commission,
            // 'last_month_commission'         =>      $last_month_commission,
            // 'this_year_commission'          =>      $this_year_commission,
            // 'last_year_commission'          =>      $last_year_commission,
            // 'today_commission'              =>      $today_commission,
            // 'yesterday_commission'          =>      $yesterday_commission,


            'commission_sale_expert'        =>      $total_commission,
            'commission_personal_shopper_1' =>      $total_ps2

        ]);

    }

    public function commission(Request $request){

        $now = Carbon::now();
        $weekStartDate = $now->startOfWeek()->format('Y-m-d H:i');
        $weekEndDate = $now->endOfWeek()->format('Y-m-d H:i');

        $commission = 30;

        $total_commission = DB::table('order_product')
        ->join('products', 'order_product.product_id', '=', 'products.id')
        ->join('orders', 'order_product.order_id', '=', 'orders.id')
        ->where('products.user_id', '=', Auth()->user()->id)
        ->where('orders.status', 'completed')
        ->where('orders.payment_status', 1)
        ->whereBetween('orders.updated_at',[$weekStartDate,$weekEndDate])
        // ->whereDate( 'orders.payment_datetime', date('Y-m-d',strtotime("now")))
        ->select('order_product.*', 'products.user_id', 'orders.order_number')
        ->sum(DB::raw('('.$commission.'/ 100) * (order_product.price * order_product.quantity)'));

        $list_commission = DB::table('order_product')
        ->join('products', 'order_product.product_id', '=', 'products.id')
        ->join('orders', 'order_product.order_id', '=', 'orders.id')
        ->where('products.user_id', '=', Auth()->user()->id)
        ->where('orders.status', 'completed')
        ->where('orders.payment_status', 1)
        ->whereBetween('orders.updated_at',[$weekStartDate,$weekEndDate])
        // ->where('orders.updated_at', '>', $date)
        ->groupBy('date')
        ->orderBy('date', 'ASC')
        ->get(
            array(
                DB::raw('DATE(orders.updated_at) AS date'),
                DB::raw('SUM( ('.$commission.'/ 100) * (order_product.price * order_product.quantity) ) as total')
            )
        );


        return response()->json([
            'commission'    => $total_commission,
            'weekStartDate' => $weekStartDate,
            'weekEndDate'   => $weekEndDate,
            'historical'    => $list_commission,
            ]);

    }


    public function search(Request $request){

        $this->validate($request, [

            'startDate' => 'required|before:endDate',
            'endDate' => 'required',

        ]);


        $startDate = $request->get('startDate');

        $endDate = $request->get('endDate');

        $commission = 30;

        $total_commission = DB::table('order_product')
        ->join('products', 'order_product.product_id', '=', 'products.id')
        ->join('orders', 'order_product.order_id', '=', 'orders.id')
        ->where('products.user_id', '=', Auth()->user()->id)
        ->where('orders.status', 'completed')
        ->where('orders.payment_status', 1)
        ->whereBetween('orders.updated_at',[$startDate,$endDate])
        // ->whereDate( 'orders.payment_datetime', date('Y-m-d',strtotime("now")))
        ->select('order_product.*', 'products.user_id', 'orders.order_number')
        ->sum(DB::raw('('.$commission.'/ 100) * (order_product.price * order_product.quantity)'));

        $list_commission = DB::table('order_product')
        ->join('products', 'order_product.product_id', '=', 'products.id')
        ->join('orders', 'order_product.order_id', '=', 'orders.id')
        ->where('products.user_id', '=', Auth()->user()->id)
        ->where('orders.status', 'completed')
        ->where('orders.payment_status', 1)
        ->whereBetween('orders.updated_at',[$startDate,$endDate])
        // ->where('orders.updated_at', '>', $date)
        ->groupBy('date')
        ->orderBy('date', 'ASC')
        ->get(
            array(
                DB::raw('DATE(orders.updated_at) AS date'),
                DB::raw('SUM( ('.$commission.'/ 100) * (order_product.price * order_product.quantity) ) as total')
            )
        );


        return response()->json([
            'commission'    => $total_commission,
            'weekStartDate' => $startDate,
            'weekEndDate'   => $endDate,
            'historical'    => $list_commission,
            ]);

    }

    public function export(){


    }
}
