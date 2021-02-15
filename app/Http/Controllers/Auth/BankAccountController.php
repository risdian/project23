<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    public function index(){

        $bank_accounts = BankAccount::where('user_id', Auth()->user()->id)->get();

        return response()->json($bank_accounts);

    }

    public function store(Request $request){

        $this->validate($request, [
            'bank_name' => 'required',
            'account_name'  => 'required',
            'account_number' => 'required',
        ]);

        $bankAccount = new BankAccount();

        $bankAccount->user_id = Auth()->user()->id;
        $bankAccount->bank_name = $request->bank_name;
        $bankAccount->account_name = $request->account_name;
        $bankAccount->account_number = $request->account_number;

        $bankAccount->save();

        if (!$bankAccount) {
            return response()->json([
                'message' => 'Error occurred while created bank account.'
            ], 201);
        }

        return response()->json([
            'message' => 'Bank account created successfully',
        ], 201);

    }

    public function edit($id){

        $bank_account = BankAccount::find($id);

        return response()->json($bank_account);

    }

    public function update(Request $request, $id){

        $this->validate($request, [
            'bank_name' => 'required',
            'account_name'  => 'required',
            'account_number' => 'required',
        ]);

        $bankAccount = BankAccount::find($id);

        $bankAccount->bank_name = $request->bank_name;
        $bankAccount->account_name = $request->account_name;
        $bankAccount->account_number = $request->account_number;

        $bankAccount->save();

        if (!$bankAccount) {
            return response()->json([
                'message' => 'Error occurred while update bank account.'
            ], 201);
        }

        return response()->json([
            'message' => 'Bank account update successfully',
        ], 201);


    }

    public function delete($id){

        $bankAccount = BankAccount::find($id);

        $bankAccount->delete();

        if (!$bankAccount) {
            return response()->json([
                'message' => 'Error occurred while delete bank account.'
            ], 201);
        }

        return response()->json([
            'message' => 'Bank account delete successfully',
        ], 201);
    }
}
