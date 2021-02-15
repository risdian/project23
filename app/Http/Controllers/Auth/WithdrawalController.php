<?php

namespace App\Http\Controllers\Auth;

use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class WithdrawalController extends Controller
{

    public function index(){

        $withdrawals = Withdrawal::where('user_id', Auth()->user()->id)->get();

        return response()->json($withdrawals);

    }

    public function store(Request $request){

        $this->validate($request, [
            'request_amount' => 'required',
            'account_name' => 'required',
            'account_number' => 'required',
            'bank_name' => 'required',
        ]);


        $withdrawal = new Withdrawal();

        $withdrawal->user_id = Auth()->user()->id;
        $withdrawal->request_amount = $request->request_amount;
        $withdrawal->request_date = Carbon::now();
        $withdrawal->account_name = $request->account_name;
        $withdrawal->bank_name = $request->bank_name;
        $withdrawal->account_number = $request->account_number;

        $withdrawal->save();


        if (!$withdrawal) {
            return response()->json([
                'message' => 'Error occurred while requesting withdrawal.'
            ], 201);
        }

        return response()->json([
            'message' => 'Withdrawal request successfully',
        ], 201);

    }

}
