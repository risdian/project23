<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;

class PersonalShopperController extends BaseController
{
    public function index(){

        $personal_shopper = User::where('status', 'personal_shopper_1')->get();

        $this->setPageTitle('Personal Shopper', 'List of all personal shopper');
        return view('admin.personal-shopper.users.index', compact('personal_shopper'));

    }

    public function view($id){

        $personal_shopper = User::findOrFail($id);

        $orders = Order::where('user_id', $id)->orderBy('created_at', 'DESC')->paginate(10);

        $this->setPageTitle('Personal Shopper', 'View Commission : '.$personal_shopper->name);

        return view('admin.personal-shopper.users.view', compact('personal_shopper', 'orders'));

    }


    public function commissions(){

        $this->setPageTitle('Personal Shopper Commissions', 'Manage Personal Shopper Commissions');
        return view('admin.personal-shopper.commissions.index');

    }
}
