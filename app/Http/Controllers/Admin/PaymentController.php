<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends BaseController
{
    public function index(){

        $payments  = Payment::all();

        $this->setPageTitle('Payment', 'List of all payment');
        return view('admin.payments.index', compact('payments'));

    }
}
