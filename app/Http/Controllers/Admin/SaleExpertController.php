<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Mail\Contact;
use App\Models\Commission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\BaseController;

class SaleExpertController extends BaseController
{
    public function index(){

        $sale_expert = User::where('status', 'sale_expert')->get();

        $this->setPageTitle('Sale Expert', 'List of all sale expert');
        return view('admin.sale-expert.users.index', compact('sale_expert'));

    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view($id)
    {


        $sale_expert = User::find($id);


        $products = DB::table('order_product')
            ->join('products', 'products.id', 'order_product.product_id')
            ->join('orders', 'orders.id', 'order_product.order_id')
            ->join('branches', 'branches.id', 'products.branch_id')
            ->where('products.user_id', $id)
            ->where('orders.payment_status', '1')
            ->groupBy(['orders.order_number', 'products.branch_id'])
            ->select('orders.id','products.branch_id','orders.order_number', DB::raw('count(order_product.product_id) as item'), 'orders.name', 'orders.phone_number', 'orders.address', 'orders.city','orders.state','orders.country', 'orders.postcode', 'orders.created_at', 'branches.name as branch')
            ->paginate(5);

        $productCount = DB::table('order_product')
            ->join('products', 'products.id', 'order_product.product_id')
            ->join('orders', 'orders.id', 'order_product.order_id')
            ->join('branches', 'branches.id', 'products.branch_id')
            ->where('products.user_id', $id)
            ->where('orders.payment_status', '1')
            ->count();



        $now = Carbon::now();

        $weekStartDate = $now->startOfWeek()->format('Y-m-d H:i');
        $weekEndDate = $now->endOfWeek()->format('Y-m-d H:i');

        $total_sale = DB::table('order_product')
        ->join('products', 'order_product.product_id', '=', 'products.id')
        ->join('orders', 'order_product.order_id', '=', 'orders.id')
        ->where('products.user_id', '=', $id)
        ->where('orders.status', 'completed')
        ->where('orders.payment_status', 1)
        ->whereYear('orders.updated_at', $now)
        ->whereMonth('orders.updated_at', $now)
        ->select('order_product.*', 'products.user_id', 'orders.order_number')
        ->sum(DB::raw('order_product.price * order_product.quantity'));

        $total_sale_status = DB::table('order_product')
        ->join('products', 'order_product.product_id', '=', 'products.id')
        ->join('orders', 'order_product.order_id', '=', 'orders.id')
        ->where('products.user_id', '=', $id)
        ->where('orders.status', 'completed')
        ->where('orders.payment_status', 1)
        ->whereYear('orders.updated_at', $now)
        ->whereMonth('orders.updated_at', $now)
        ->take(1)->get();


        $commission_id = $total_sale_status->pluck('se_commission')->first();

        if($commission_id != null){

            $commission = Commission::findorFail($commission_id);

            if($commission != null){

                $comission_attributes = $commission->attributes()
                    ->where('max', '>=', $total_sale)
                    ->first();

                $total_commission = ($comission_attributes->value / 100) * $total_sale;

                $list_commission = DB::table('order_product')
                ->join('products', 'order_product.product_id', '=', 'products.id')
                ->join('orders', 'order_product.order_id', '=', 'orders.id')
                ->where('products.user_id', '=', $id)
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
                        DB::raw('SUM( ('.$comission_attributes->value.'/ 100) * (order_product.price * order_product.quantity) ) as commission')
                    )
                );

            }else{

                $total_commission = 0;
                $list_commission = [];

            }
        }else{

            $total_commission = 0;
            $list_commission = [];
        }

        $this->setPageTitle('Sale Expert', 'View Commission : '.$sale_expert->name);

        return view('admin.sale-expert.users.view', compact('sale_expert', 'products', 'productCount',
        'total_sale', 'total_commission', 'list_commission'));
    }


    public function create(){

        $this->setPageTitle('Sale Expert', 'Create sale expert');
        return view('admin.sale-expert.users.create');


    }


    public function store(Request $request){

        $this->validate($request, [
            'name'          =>  'required|max:191',
            'nric'          =>  'required|regex:/^\d{6}-\d{2}-\d{4}$/|unique:users',
            'mobile'        =>  'required|regex:/^(\+?6?01)[0-46-9]-*[0-9]{7,8}$/|unique:users',
            'email'         =>  'required|string|email|max:255|unique:users',
        ]);

        $user = new User;

        $user->name = $request->name;
        $user->nric = $request->nric;
        $user->mobile = $request->mobile;
        $user->email = $request->email;
        $user->password = bcrypt('Smsgvs32!@#$');
        $user->status = 'sale_expert';
        $user->save();

        $token = app(\Illuminate\Auth\Passwords\PasswordBroker::class)->createToken($user);

        Mail::to($user->email)
            ->send(new Contact($user->name, $token, $user->email));

        if (!$user) {
            return $this->responseRedirectBack('Error occurred while creating Sale expert.', 'error', true, true);
        }
        return $this->responseRedirect('admin.sale-expert.users.index', 'Sale expert added successfully' ,'success',false, false);

    }


    public function update(Request $request){

        $this->validate($request, [
            'name'          =>  'required|max:191',
            'nric'          =>  'required|regex:/^\d{6}-\d{2}-\d{4}$/|unique:users,nric,'.$request->id,
            'mobile'        =>  'required|regex:/^(\+?6?01)[0-46-9]-*[0-9]{7,8}$/|unique:users,mobile,'.$request->id,
            'email'         =>  'required|string|email|max:255|unique:users,email,'.$request->id,
        ]);

        $sale_expert = User::find($request->id);

        $sale_expert->name = $request->name;
        $sale_expert->nric = $request->nric;
        $sale_expert->mobile = $request->mobile;
        $sale_expert->email = $request->email;
        $sale_expert->save();

        if (!$sale_expert) {
            return $this->responseRedirectBack('Error occurred while update Sale expert.', 'error', true, true);
        }
        return $this->responseRedirect('admin.sale-expert.users.index', 'Sale expert update successfully' ,'success',false, false);

    }
}
