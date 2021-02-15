<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Commission;

class ReportController extends Controller
{
    public function personal_shopper_report(){

        $now = Carbon::now();

        $weekStartDate = $now->startOfWeek()->format('Y-m-d H:i');
        $weekEndDate = $now->endOfWeek()->format('Y-m-d H:i');

        $users = User::where('parent_id', Auth()->user()->id)->pluck('id')->toArray();

        $agent_list = Order::whereIn('user_id', $users)
        ->where('payment_status', 1)
        ->where('status', 'completed')
        ->whereBetween('updated_at',[$weekStartDate,$weekEndDate])
        ->groupBy('date')
        ->orderBy('date', 'DESC') // or ASC
        ->get(array(
            DB::raw('DATE(updated_at) AS date'),
            DB::raw('COUNT(*) as count'),
            DB::raw('SUM((ps_agent_commission/ 100) * sub_total) as commission'),
            DB::raw('SUM(grand_total) as sale'),
        ));

        $agent_commission_total = Order::whereIn('user_id', $users)
        ->where('payment_status', 1)
        ->where('status', 'completed')
        ->whereBetween('updated_at',[$weekStartDate,$weekEndDate])
        ->sum(
            DB::raw('(ps_agent_commission/ 100) * (sub_total)')
        );

        $agent_sale_total = Order::whereIn('user_id', $users)
        ->where('payment_status', 1)
        ->where('status', 'completed')
        ->whereBetween('updated_at',[$weekStartDate,$weekEndDate])
        ->sum('grand_total');

        $agent_number = Order::whereIn('user_id', $users)
        ->where('payment_status', 1)
        ->where('status', 'completed')
        ->whereBetween('updated_at',[$weekStartDate,$weekEndDate])
        ->count();

        $personal_shopper_commission_total =  Order::where('user_id', Auth()->user()->id)
        ->where('payment_status', 1)
        ->where('status', 'completed')
        ->whereBetween('updated_at',[$weekStartDate,$weekEndDate])
        ->sum(DB::raw('(ps_commission/ 100) * (sub_total)'));

        $personal_shopper_sale_total =  Order::where('user_id', Auth()->user()->id)
        ->where('payment_status', 1)
        ->where('status', 'completed')
        ->whereBetween('updated_at',[$weekStartDate,$weekEndDate])
        ->sum('grand_total');

        $personal_shopper_list = Order::where('user_id', Auth()->user()->id)
        ->where('payment_status', 1)
        ->where('status', 'completed')
        ->whereBetween('updated_at',[$weekStartDate,$weekEndDate])
        ->groupBy('date')
        ->orderBy('date', 'DESC') // or ASC
        ->get(array(
            DB::raw('DATE(updated_at) AS date'),
            DB::raw('COUNT(*) as count'),
            DB::raw('SUM((ps_commission/ 100) * sub_total) as commission'),
            DB::raw('SUM(grand_total) as sale'),
        ));

        $personal_shopper_number =  Order::where('user_id', Auth()->user()->id)
        ->where('payment_status', 1)
        ->where('status', 'completed')
        ->whereBetween('updated_at',[$weekStartDate,$weekEndDate])
        ->count();


        return response()->json([
            'total_sale'                        => $agent_sale_total + $personal_shopper_sale_total,
            'total_commission'                  => $agent_commission_total + $personal_shopper_commission_total,

            'agent_sale_total'                  => $agent_sale_total,
            'agent_commission_total'            => $agent_commission_total,
            'agent_number'                      => $agent_number,
            'agent_list'                        => $agent_list,

            'personal_shopper_sale_total'       => $personal_shopper_sale_total,
            'personal_shopper_commission_total' => $personal_shopper_commission_total,
            'personal_shopper_number'           => $personal_shopper_number,
            'personal_shopper_list'             => $personal_shopper_list,

            'weekStartDate'                     => $weekStartDate,
            'weekEndDate'                       => $weekEndDate,
        ]);

    }

    public function personal_shopper_search(Request $request){

        $this->validate($request, [
            'startDate' => 'required|before_or_equal:endDate',
            'endDate' => 'required',
        ]);

        $weekStartDate = $request->get('startDate');

        $weekEndDate = $request->get('endDate');

        $users = User::where('parent_id', Auth()->user()->id)->pluck('id')->toArray();

        $agent_list = Order::whereIn('user_id', $users)
        ->where('payment_status', 1)
        ->where('status', 'completed')
        ->whereBetween('updated_at',[$weekStartDate,$weekEndDate])
        ->groupBy('date')
        ->orderBy('date', 'DESC') // or ASC
        ->get(array(
            DB::raw('DATE(updated_at) AS date'),
            DB::raw('COUNT(*) as count'),
            DB::raw('SUM((ps_agent_commission/ 100) * sub_total) as commission'),
            DB::raw('SUM(grand_total) as sale'),
        ));

        $agent_commission_total = Order::whereIn('user_id', $users)
        ->where('payment_status', 1)
        ->where('status', 'completed')
        ->whereBetween('updated_at',[$weekStartDate,$weekEndDate])
        ->sum(
            DB::raw('(ps_agent_commission/ 100) * (sub_total)')
        );

        $agent_sale_total = Order::whereIn('user_id', $users)
        ->where('payment_status', 1)
        ->where('status', 'completed')
        ->whereBetween('updated_at',[$weekStartDate,$weekEndDate])
        ->sum('grand_total');

        $agent_number = Order::whereIn('user_id', $users)
        ->where('payment_status', 1)
        ->where('status', 'completed')
        ->whereBetween('updated_at',[$weekStartDate,$weekEndDate])
        ->count();

        $personal_shopper_commission_total =  Order::where('user_id', Auth()->user()->id)
        ->where('payment_status', 1)
        ->where('status', 'completed')
        ->whereBetween('updated_at',[$weekStartDate,$weekEndDate])
        ->sum(DB::raw('(ps_commission/ 100) * (sub_total)'));

        $personal_shopper_sale_total =  Order::where('user_id', Auth()->user()->id)
        ->where('payment_status', 1)
        ->where('status', 'completed')
        ->whereBetween('updated_at',[$weekStartDate,$weekEndDate])
        ->sum('grand_total');

        $personal_shopper_list = Order::where('user_id', Auth()->user()->id)
        ->where('payment_status', 1)
        ->where('status', 'completed')
        ->whereBetween('updated_at',[$weekStartDate,$weekEndDate])
        ->groupBy('date')
        ->orderBy('date', 'DESC') // or ASC
        ->get(array(
            DB::raw('DATE(updated_at) AS date'),
            DB::raw('COUNT(*) as count'),
            DB::raw('SUM((ps_commission/ 100) * sub_total) as commission'),
            DB::raw('SUM(grand_total) as sale'),
        ));

        $personal_shopper_number =  Order::where('user_id', Auth()->user()->id)
        ->where('payment_status', 1)
        ->where('status', 'completed')
        ->whereBetween('updated_at',[$weekStartDate,$weekEndDate])
        ->count();


        return response()->json([
            'total_sale'                        => $agent_sale_total + $personal_shopper_sale_total,
            'total_commission'                  => $agent_commission_total + $personal_shopper_commission_total,

            'agent_sale_total'                  => $agent_sale_total,
            'agent_commission_total'            => $agent_commission_total,
            'agent_number'                      => $agent_number,
            'agent_list'                        => $agent_list,

            'personal_shopper_sale_total'       => $personal_shopper_sale_total,
            'personal_shopper_commission_total' => $personal_shopper_commission_total,
            'personal_shopper_number'           => $personal_shopper_number,
            'personal_shopper_list'             => $personal_shopper_list,

            'weekStartDate'                     => $weekStartDate,
            'weekEndDate'                       => $weekEndDate,
        ]);
    }

    public function agent_report(){


        $now = Carbon::now();

        $weekStartDate = $now->startOfWeek()->format('Y-m-d H:i');
        $weekEndDate = $now->endOfWeek()->format('Y-m-d H:i');

        $total_sale =  Order::where('user_id', Auth()->user()->id)
        ->where('payment_status', 1)
        ->where('status', 'completed')
        ->whereYear('updated_at', date('Y', strtotime('now')))
        ->sum('grand_total');

        $total_commission =  Order::where('user_id', Auth()->user()->id)
        ->where('payment_status', 1)
        ->where('status', 'completed')
        ->whereYear('updated_at', date('Y', strtotime('now')))
        ->sum(DB::raw('(agent_commission/ 100) * (sub_total)'));

        $order_list = Order::where('user_id', Auth()->user()->id)
        ->where('payment_status', 1)
        ->where('status', 'completed')
        ->whereBetween('updated_at',[$weekStartDate,$weekEndDate])
        ->groupBy('date')
        ->orderBy('date', 'DESC') // or ASC
        ->get(array(
            DB::raw('DATE(updated_at) AS date'),
            DB::raw('COUNT(*) as count'),
            DB::raw('SUM((agent_commission/ 100) * sub_total) as commission'),
            DB::raw('SUM(grand_total) as sale'),
        ));

        return response()->json([
            'total_sale'                        => $total_sale,
            'total_commission'                  => $total_commission,
            'order_list'                        => $order_list,

            'weekStartDate'                     => $weekStartDate,
            'weekEndDate'                       => $weekEndDate,
        ]);

    }

    public function agent_report_search(Request $request){

        $this->validate($request, [
            'startDate' => 'required|before_or_equal:endDate',
            'endDate' => 'required',
        ]);

        $weekStartDate = $request->get('startDate');

        $weekEndDate = $request->get('endDate');

        $total_sale =  Order::where('user_id', Auth()->user()->id)
        ->where('payment_status', 1)
        ->where('status', 'completed')
        ->whereYear('updated_at', date('Y', strtotime('now')))
        ->sum('grand_total');

        $total_commission =  Order::where('user_id', Auth()->user()->id)
        ->where('payment_status', 1)
        ->where('status', 'completed')
        ->whereYear('updated_at', date('Y', strtotime('now')))
        ->sum(DB::raw('(agent_commission/ 100) * (sub_total)'));

        $order_list = Order::where('user_id', Auth()->user()->id)
        ->where('payment_status', 1)
        ->where('status', 'completed')
        ->whereBetween('updated_at',[$weekStartDate,$weekEndDate])
        ->groupBy('date')
        ->orderBy('date', 'DESC') // or ASC
        ->get(array(
            DB::raw('DATE(updated_at) AS date'),
            DB::raw('COUNT(*) as count'),
            DB::raw('SUM((agent_commission/ 100) * sub_total) as commission'),
            DB::raw('SUM(grand_total) as sale'),
        ));

        return response()->json([
            'total_sale'                        => $total_sale,
            'total_commission'                  => $total_commission,
            'order_list'                        => $order_list,

            'weekStartDate'                     => $weekStartDate,
            'weekEndDate'                       => $weekEndDate,
        ]);

    }

    public function sale_expert_report(){

        // commisson SE is dynamic
        // comission can be change but
        /**
         * how to calculate commission SE
         * Commission SE is in array base on
         */

        $now = Carbon::now();

        $weekStartDate = $now->startOfWeek()->format('Y-m-d H:i');
        $weekEndDate = $now->endOfWeek()->format('Y-m-d H:i');

        $total_sale = DB::table('order_product')
        ->join('products', 'order_product.product_id', '=', 'products.id')
        ->join('orders', 'order_product.order_id', '=', 'orders.id')
        ->where('products.user_id', '=', Auth()->user()->id)
        ->where('orders.status', 'completed')
        ->where('orders.payment_status', 1)
        ->whereYear('orders.updated_at', $now)
        ->whereMonth('orders.updated_at', $now)
        ->select('order_product.*', 'products.user_id', 'orders.order_number')
        ->sum(DB::raw('order_product.price * order_product.quantity'));

        $total_sale_status = DB::table('order_product')
        ->join('products', 'order_product.product_id', '=', 'products.id')
        ->join('orders', 'order_product.order_id', '=', 'orders.id')
        ->where('products.user_id', '=', Auth()->user()->id)
        ->where('orders.status', 'completed')
        ->where('orders.payment_status', 1)
        ->whereYear('orders.updated_at', $now)
        ->whereMonth('orders.updated_at', $now)
        ->take(1)->get();

        $commission_id = $total_sale_status->pluck('se_commission')->toArray();


        $commission = Commission::where('id', $commission_id)->first();

        $comission_attributes = $commission->attributes()
            ->where('range_end', '>=', $total_sale)
            ->first();

        $total_commission = ($comission_attributes->price / 100) * $total_sale;

        $list_commission = DB::table('order_product')
        ->join('products', 'order_product.product_id', '=', 'products.id')
        ->join('orders', 'order_product.order_id', '=', 'orders.id')
        ->where('products.user_id', '=', Auth()->user()->id)
        ->where('orders.status', 'completed')
        ->where('orders.payment_status', 1)
        ->whereYear('orders.updated_at', $now)
        ->whereMonth('orders.updated_at', $now)
        ->groupBy('date')
        ->orderBy('date', 'ASC')
        ->get(
            array(
                DB::raw('DATE(orders.updated_at) AS date'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(order_product.price * order_product.quantity) as sale'),
                DB::raw('SUM( ('.$comission_attributes->price.'/ 100) * (order_product.price * order_product.quantity) ) as commission')
            )
        );

        return response()->json([
            'total_sale'        => $total_sale,
            'total_commission'  => $total_commission,
            'list_commission'   => $list_commission,
        ]);

    }


    public function sale_expert_report_search(Request $request){

        $this->validate($request, [
            'month' => 'required',
            'year' => 'required',
        ]);

        $month = date('m', strtotime($request->get('month')));
        $year = date('Y', strtotime($request->get('year')));


        $total_sale = DB::table('order_product')
        ->join('products', 'order_product.product_id', '=', 'products.id')
        ->join('orders', 'order_product.order_id', '=', 'orders.id')
        ->where('products.user_id', '=', Auth()->user()->id)
        ->where('orders.status', 'completed')
        ->where('orders.payment_status', 1)
        ->whereYear('orders.updated_at', $year)
        ->whereMonth('orders.updated_at', $month)
        ->select('order_product.*', 'products.user_id', 'orders.order_number')
        ->sum(DB::raw('order_product.price * order_product.quantity'));

        $total_sale_status = DB::table('order_product')
        ->join('products', 'order_product.product_id', '=', 'products.id')
        ->join('orders', 'order_product.order_id', '=', 'orders.id')
        ->where('products.user_id', '=', Auth()->user()->id)
        ->where('orders.status', 'completed')
        ->where('orders.payment_status', 1)
        ->whereYear('orders.updated_at', $year)
        ->whereMonth('orders.updated_at', $month)
        ->take(1)->get();

        $commission_id = $total_sale_status->pluck('se_commission')->toArray();


        $commission = Commission::where('id', $commission_id)->first();

        if($commission != null){

            $comission_attributes = $commission->attributes()
            ->where('range_end', '>=', $total_sale)
            ->first();

            $total_commission = ($comission_attributes->price / 100) * $total_sale;

            $list_commission = DB::table('order_product')
            ->join('products', 'order_product.product_id', '=', 'products.id')
            ->join('orders', 'order_product.order_id', '=', 'orders.id')
            ->where('products.user_id', '=', Auth()->user()->id)
            ->where('orders.status', 'completed')
            ->where('orders.payment_status', 1)
            ->whereYear('orders.updated_at', $year)
            ->whereMonth('orders.updated_at', $month)
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get(
                array(
                    DB::raw('DATE(orders.updated_at) AS date'),
                    DB::raw('COUNT(*) as count'),
                    DB::raw('SUM(order_product.price * order_product.quantity) as sale'),
                    DB::raw('SUM( ('.$comission_attributes->price.'/ 100) * (order_product.price * order_product.quantity) ) as commission')
                )
            );


        }else{

            $total_commission = 0;
            $list_commission = [];

        }



        return response()->json([
            'total_sale'        => $total_sale,
            'total_commission'  => $total_commission,
            'list_commission'   => $list_commission,
        ]);

    }


    public function personal_shopper_report_details($date){


        $personal_shopper_list = Order::where('user_id', Auth()->user()->id)
        ->where('payment_status', 1)
        ->where('status', 'completed')
        ->whereDate('updated_at', $date)
        ->get();

        return response()->json([
            'personal_shopper_list' => $personal_shopper_list,
        ]);

    }

    public function agent_shopper_report_details($date){

        $users = User::where('parent_id', Auth()->user()->id)->pluck('id')->toArray();

        $agent_list = Order::whereIn('user_id', $users)
        ->where('payment_status', 1)
        ->where('status', 'completed')
        ->whereDate('updated_at', $date)
        ->get();

        return response()->json([
            'agent_list'        => $agent_list,
        ]);

    }

    public function sale_expert_report_details($date){

        $sale_expert_list = DB::table('order_product')
        ->join('products', 'order_product.product_id', '=', 'products.id')
        ->join('orders', 'order_product.order_id', '=', 'orders.id')
        ->where('products.user_id', '=', Auth()->user()->id)
        ->where('orders.status', 'completed')
        ->where('orders.payment_status', 1)
        ->whereDate('orders.updated_at', $date)
        ->get();

        return response()->json([
            'sale_expert_list'        => $sale_expert_list,
        ]);

    }


}
