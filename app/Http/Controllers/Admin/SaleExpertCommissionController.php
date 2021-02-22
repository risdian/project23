<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Commission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Models\CommissionAttributes;

class SaleExpertCommissionController extends BaseController
{
    public function index(){

        $commissions = Commission::all();

        $this->setPageTitle('Commissions', 'List of all commission');
        return view('admin.sale-expert.commissions.index', compact('commissions'));

    }

    public function create(){

        $this->setPageTitle('Commission', 'Create Commission');
        return view('admin.sale-expert.commissions.create');
    }

    public function store(Request $request){

        $request->validate([
            "start"             => 'required',
            "value"             => "required|array|min:1",
            "value.*"           => "required|string|distinct|min:1",
            "min"               => "required|array|min:1",
            "min.*"             => "required|string|distinct|min:1",
            "max"               => "required|array|min:1",
            "max.*"             => "required|string|distinct|min:1",
        ]);

        $myDate = $request->start;

        $date = Carbon::createFromFormat('Y-m', $myDate)
                        ->firstOfMonth()
                        ->format('Y-m-d');

        $commissions = new Commission();

        $commissions->user_id = Auth()->user()->id;
        $commissions->start = $date;

        $commissions->save();

        $value = $request->value;
        $min = $request->min;
        $max = $request->max;
        for($count = 0; $count < count($value); $count++)
        {
            $commission_attributes = new CommissionAttributes([
                'value'           => $value[$count],
                'min'             => $min[$count],
                'max'             => $max[$count],
            ]);
            $commissions->attributes()->save($commission_attributes);

        }
        // return ['success' => true, 'message' => 'New commission created !!'];

        return response()->json(['url'=> route('admin.sale-expert.commissions.index')]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {

        $commission = Commission::find($id);

        $start =  Carbon::createFromFormat('Y-m-d H:i:s', $commission->start)->format('Y-m');



        $this->setPageTitle('Commissions', 'Edit Commission : '.$start);

        return view('admin.sale-expert.commissions.edit', compact('commission','start'));
    }

    public function update(Request $request){

        $request->validate([
            "start"             => 'required',
            "value"             => "required|array|min:1",
            "value.*"           => "required|string|distinct|min:1",
            "min"               => "required|array|min:1",
            "min.*"             => "required|string|distinct|min:1",
            "max"               => "required|array|min:1",
            "max.*"             => "required|string|distinct|min:1",
        ]);

        $myDate = $request->start;

        $date = Carbon::createFromFormat('Y-m', $myDate)
                        ->firstOfMonth()
                        ->format('Y-m-d');

        $commissions = Commission::find($request->id);

        $commissions->user_id = Auth()->user()->id;
        $commissions->start = $date;

        $commissions->save();

        $commissions->attributes()->delete();

        $value = $request->value;
        $min = $request->min;
        $max = $request->max;
        for($count = 0; $count < count($value); $count++)
        {
            $commission_attributes = new CommissionAttributes([
                'value'           => $value[$count],
                'min'             => $min[$count],
                'max'             => $max[$count],
            ]);
            $commissions->attributes()->save($commission_attributes);

        }
        return response()->json(['url'=> route('admin.sale-expert.commissions.index')]);

        // return ['success' => true, 'message' => 'Commission updated !!'];

    }

    public function status(Request $request){

        $commission = Commission::where('id', '!=', $request->id)->update(['status' => 0]);

        $commission = Commission::find($request->id);

        $commission->status = 1;

        $commission->save();


        if (!$commission) {
            return $this->responseRedirectBack('Error occurred while creating commission.', 'error', true, true);
        }
        return $this->responseRedirect('admin.sale-expert.commissions.index', 'commission updated' ,'success',false, false);

    }

}
