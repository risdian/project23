<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Courier;
use App\Models\CourierRates;
use Illuminate\Http\Request;

class CourierController extends BaseController
{
    public function index(){

        $couriers = Courier::all();

        $this->setPageTitle('Courier', 'List of all Courier');
        return view('admin.couriers.index', compact('couriers'));

    }

    public function create(){

        $this->setPageTitle('Courier', 'Create Courier');
        return view('admin.couriers.create');
    }

    public function store(Request $request){

        $request->validate([
            "name"              => 'required',
            "shipping_method"              => 'required',
            "country"           => "required|array|min:1",
            "country.*"         => "required|string|min:1",
            "region"            => "required|array|min:1",
            "region.*"          => "required|string|min:1",
            "zip_from"          => "required|array|min:1",
            "zip_from.*"        => "required|string|min:1",
            "zip_to"            => "required|array|min:1",
            "zip_to.*"          => "required|string|min:1",
            "weight_from"       => "required|array|min:1",
            "weight_from.*"     => "required|string|min:1",
            "weight_to"         => "required|array|min:1",
            "weight_to.*"       => "required|string|min:1",
            "price"             => "required|array|min:1",
            "price.*"           => "required|string|min:1",
        ]);


        $courier = new Courier();

        $courier->name = $request->name;
        $courier->shipping_method = $request->shipping_method;

        $courier->save();

        $country        = $request->country;
        $region         = $request->region;
        $zip_from       = $request->zip_from;
        $zip_to         = $request->zip_to;
        $weight_from    = $request->weight_from;
        $weight_to      = $request->weight_to;
        $price          = $request->price;

        for($count = 0; $count < count($country); $count++)
        {
            $courier_rates = new CourierRates([
                'country'               => $country[$count],
                'region'                => $region[$count],
                'zip_from'              => $zip_from[$count],
                'zip_to'                => $zip_to[$count],
                'weight_from'           => $weight_from[$count],
                'weight_to'             => $weight_to[$count],
                'price'                 => $price[$count],
            ]);
            $courier->rates()->save($courier_rates);

        }

        return response()->json(['url'=> route('admin.couriers.index')]);
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {

        $courier = Courier::find($id);


        $this->setPageTitle('Courier', 'Edit Courier : '.$courier->name);

        return view('admin.couriers.edit', compact('courier'));
    }

    public function update(Request $request){

        $request->validate([
            "name"              => 'required',
            "shipping_method"              => 'required',
            "country"           => "required|array|min:1",
            "country.*"         => "required|string|min:1",
            "region"            => "required|array|min:1",
            "region.*"          => "required|string|min:1",
            "zip_from"          => "required|array|min:1",
            "zip_from.*"        => "required|string|min:1",
            "zip_to"            => "required|array|min:1",
            "zip_to.*"          => "required|string|min:1",
            "weight_from"       => "required|array|min:1",
            "weight_from.*"     => "required|string|min:1",
            "weight_to"         => "required|array|min:1",
            "weight_to.*"       => "required|string|min:1",
            "price"             => "required|array|min:1",
            "price.*"           => "required|string|min:1",
        ]);


        $courier = Courier::find($request->id);

        $courier->name = $request->name;
        $courier->shipping_method = $request->shipping_method;

        $courier->save();

        $courier->rates()->delete();

        $country        = $request->country;
        $region         = $request->region;
        $zip_from       = $request->zip_from;
        $zip_to         = $request->zip_to;
        $weight_from    = $request->weight_from;
        $weight_to      = $request->weight_to;
        $price          = $request->price;

        for($count = 0; $count < count($country); $count++)
        {
            $courier_rates = new CourierRates([
                'country'               => $country[$count],
                'region'                => $region[$count],
                'zip_from'              => $zip_from[$count],
                'zip_to'                => $zip_to[$count],
                'weight_from'           => $weight_from[$count],
                'weight_to'             => $weight_to[$count],
                'price'                 => $price[$count],
            ]);
            $courier->rates()->save($courier_rates);

        }

        return response()->json(['url'=> route('admin.couriers.index')]);


    }
}
