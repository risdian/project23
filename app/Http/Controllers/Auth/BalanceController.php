<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BalanceController extends Controller
{
    public function index(Request $request){

        /**
         * personal shopper total balance
         */
        $orders = Order::where('user_id', Auth()->user()->id)
            ->where('payment_status', 1)
            ->where('status', 'completed')
            ->sum(DB::raw('(ps_commission/ 100) * (sub_total)'));

        $users = User::where('parent_id', Auth()->user()->id)
            ->pluck('id')
            ->toArray();

        $agent_commission_total = Order::whereIn('user_id', $users)
            ->where('payment_status', 1)
            ->where('status', 'completed')
            ->sum(
                DB::raw('(ps_agent_commission/ 100) * (sub_total)')
            );

        $total = $orders + $agent_commission_total;

        /**
         * agent total balance
         */
        // $orders = Order::where('user_id', Auth()->user()->id)
        //     ->where('payment_status', 1)
        //     ->where('status', 'completed')
        //     ->sum(DB::raw('(agent_commission/ 100) * (sub_total)'));

        return response()->json($total);

    }

    public function personal_shopper(){

        $orders = Order::where('user_id', Auth()->user()->id)
        ->where('payment_status', 1)
        ->where('status', 'completed')
        ->sum(DB::raw('(ps_commission/ 100) * (sub_total)'));

        $users = User::where('parent_id', Auth()->user()->id)
            ->pluck('id')
            ->toArray();

        $agent_commission_total = Order::whereIn('user_id', $users)
            ->where('payment_status', 1)
            ->where('status', 'completed')
            ->sum(
                DB::raw('(ps_agent_commission/ 100) * (sub_total)')
            );

        $total = $orders + $agent_commission_total;

        return response()->json($total);

    }

    public function agent(){

        $total = Order::where('user_id', Auth()->user()->id)
            ->where('payment_status', 1)
            ->where('status', 'completed')
            ->sum(DB::raw('(agent_commission/ 100) * (sub_total)'));

        return response()->json($total);

    }
}
