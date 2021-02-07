<?php

namespace App\Http\Controllers\Auth;

use config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function tax(){

        $tax = config('settings.tax_value');

        return response()->json($tax);

    }

    public function commision_tier(){

        $tier = config('settings.personal_shopper_tier_1');

        return response()->json($tier);

    }
}
