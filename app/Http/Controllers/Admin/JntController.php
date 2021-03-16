<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\j_n_t;
use Illuminate\Http\Request;

class JntController extends BaseController
{
    public function index(){

        $jnt = j_n_t::all();

        $this->setPageTitle('Shipping Rates J&T', 'List of all Rates');
        return view('admin.jnt.index', compact('jnt'));

    }

    public function create(){

        $this->setPageTitle('Shipping Rates J&T', 'Add new Rates');
        return view('admin.jnt.create');

    }

    public function store(Request $request){

        $this->validate($request, [
            'shipping_type'         =>  'required|max:191',
            'country'               =>  'required|max:191',
            'region'                =>  'required|max:191',
            'zip_from'              =>  'required|max:191',
            'zip_to'                =>  'required|max:191',
            'weight_from'           =>  'required|max:191',
            'weight_to'             =>  'required|max:191',
            'price'                 =>  'required|max:191',

        ]);

        $jnt = new j_n_t;

        $jnt->shipping_type     = $request->shipping_type;
        $jnt->country           = $request->country;
        $jnt->region            = $request->region;
        $jnt->zip_from          = $request->zip_from;
        $jnt->zip_to            = $request->zip_to;
        $jnt->weight_from       = $request->weight_from;
        $jnt->weight_to         = $request->weight_to;
        $jnt->price             = $request->price;

        $jnt->save();

        if (!$jnt) {
            return $this->responseRedirectBack('Error occurred while creating j&t Rates.', 'error', true, true);
        }
        return $this->responseRedirect('admin.jnt.index', 'j&t Rates added successfully' ,'success',false, false);


    }

    public function edit($id){

        $rates = j_n_t::findorfail($id);

        $this->setPageTitle('Shipping Rates J&T', 'Add new Rates');
        return view('admin.jnt.edit', compact('rates'));

    }

    public function update(Request $request)
    {

        $this->validate($request, [
            'shipping_type'         =>  'required|max:191',
            'country'               =>  'required|max:191',
            'region'                =>  'required|max:191',
            'zip_from'              =>  'required|max:191',
            'zip_to'                =>  'required|max:191',
            'weight_from'           =>  'required|max:191',
            'weight_to'             =>  'required|max:191',
            'price'                 =>  'required|max:191',

        ]);

        $jnt = j_n_t::findorFail($request->id);

        $jnt->shipping_type     = $request->shipping_type;
        $jnt->country           = $request->country;
        $jnt->region            = $request->region;
        $jnt->zip_from          = $request->zip_from;
        $jnt->zip_to            = $request->zip_to;
        $jnt->weight_from       = $request->weight_from;
        $jnt->weight_to         = $request->weight_to;
        $jnt->price             = $request->price;

        $jnt->save();

        if (!$jnt) {
            return $this->responseRedirectBack('Error occurred while saving j&t Rates.', 'error', true, true);
        }
        return $this->responseRedirect('admin.jnt.index', 'j&t Rates update successfully' ,'success',false, false);


    }
}
