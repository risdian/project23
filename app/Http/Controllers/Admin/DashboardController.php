<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index(){


        $users = User::all()->count();

        $products = Product::all()->count();

        return $users;


    }
}
