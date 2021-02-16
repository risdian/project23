<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Commission;
use Illuminate\Http\Request;

class CommissionController extends BaseController
{
    public function index(){

        $commissions = Commission::all();

        $this->setPageTitle('Commissions', 'List of all commission');
        return view('admin.commissions.index', compact('commissions'));

    }

    public function create(){

        $this->setPageTitle('Commission', 'Create Commission');
        return view('admin.commissions.create');
    }

    public function store(Request $request){

        $request->validate([
            "name"      => 'required',
            "price"    => "required|array|min:1",
            "price.*"  => "required|string|distinct|min:1",
            "min"    => "required|array|min:1",
            "min.*"  => "required|string|distinct|min:1",
            "max"    => "required|array|min:1",
            "max.*"  => "required|string|distinct|min:1",
        ]);

        return 'aneer';

    }
}
