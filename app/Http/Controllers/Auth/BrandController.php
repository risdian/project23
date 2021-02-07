<?php

namespace App\Http\Controllers\Auth;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Contracts\BrandContract;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;

class BrandController extends BaseController
{
    /**
     * @var BrandContract
     */
    protected $brandRepository;

    /**
     * BrandController constructor.
     * @param BrandContract $brandRepository
     */
    public function __construct(BrandContract $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    public function index(Request $request){

        $brand = Brand::all();

        return response()->json($brand);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'name'      =>  'required|max:191',
            // 'logo'     =>  'mimes:jpg,jpeg,png|max:1000'
        ]);

        $params = $request->except('_token');

        $brand = $this->brandRepository->createBrand($params);

        if (!$brand) {
            return response()->json([
                'message' => 'Error occurred while creating brand.'
            ], 201);
        }
        return response()->json([
            'message' => 'Brand added successfully'
        ], 201);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $brand = $this->brandRepository->findBrandById($id);

        return response()->json($brand);
    }

        /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'name'      =>  'required|max:191',
            // 'logo'     =>  'mimes:jpg,jpeg,png|max:1000'
        ]);


        // return $request->name;

        $params = $request->except('_token');

        $brand = $this->brandRepository->updateBrand($params);

        if (!$brand) {
            return response()->json([
                'message' => 'Error occurred while updating brand.'
            ], 201);
        }
        return response()->json([
            'message' => 'Brand updated successfully'
        ], 201);

    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $brand = $this->brandRepository->deleteBrand($id);

        if (!$brand) {
            return response()->json([
                'message' => 'Error occurred while deleting brand.'
            ], 201);
        }
        return response()->json([
            'message' => 'Brand deleted successfully'
        ], 201);

    }
}
