<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(){


        $now = Carbon::now();

        $list = Order::where('payment_status', 1)
        ->where('status', 'completed')
        ->whereYear('updated_at',$now)
        ->whereMonth('updated_at',$now)
        ->groupBy('date')
        ->orderBy('date', 'DESC') // or ASC
        ->get(array(
            DB::raw('DATE(updated_at) AS date'),
            DB::raw('COUNT(*) as count'),
            DB::raw('SUM((ps_commission/ 100) * sub_total) as commission'),
            DB::raw('SUM(grand_total) as sale'),
        ));

        return view('admin.dashboard.index', compact('list'));

    }
}
