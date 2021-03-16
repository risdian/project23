<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Poscode;
use Illuminate\Http\Request;

class PoscodeController extends BaseController
{
    public function index(){

        $poscodes = Poscode::all();

        $this->setPageTitle('Poscode', 'List of all poscode');
        return view('admin.poscode.index', compact('poscodes'));

    }

    public function create(){

        $this->setPageTitle('Poscode', 'Add new poscode');
        return view('admin.poscode.create');

    }

    public function store(Request $request){

        $this->validate($request, [
            'region'         =>  'required|max:191',
            'poscode'               =>  'required|max:191',
            'state'                =>  'required|max:191',
            'country'              =>  'required|max:191',
        ]);

        $poscode = new Poscode();

        $poscode->region           = $request->region;
        $poscode->poscode          = $request->poscode;
        $poscode->state            = $request->state;
        $poscode->country          = $request->country;

        $poscode->save();

        if (!$poscode) {
            return $this->responseRedirectBack('Error occurred while creating poscode.', 'error', true, true);
        }
        return $this->responseRedirect('admin.poscode.index', 'new poscode added successfully' ,'success',false, false);


    }


    public function edit($id){

        $poscode = Poscode::findorfail($id);

        $this->setPageTitle('Poscode', 'Edit Poscode');
        return view('admin.poscode.edit', compact('poscode'));

    }
}
