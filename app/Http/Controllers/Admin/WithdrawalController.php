<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class WithdrawalController extends BaseController
{
    public function index(){

        $withdrawals = Withdrawal::all();

        return $withdrawals;

    }
}
