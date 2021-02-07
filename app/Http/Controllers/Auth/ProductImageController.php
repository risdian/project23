<?php

namespace App\Http\Controllers\Auth;

use App\Traits\UploadAble;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Contracts\ProductContract;
use App\Http\Controllers\Controller;

class ProductImageController extends Controller
{
    use UploadAble;

    protected $productRepository;

    public function __construct(ProductContract $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function upload(Request $request)
    {
        // return $request->all();

        $this->validate($request, [
            'image.*'              =>  'mimes:jpg,jpeg,png',
        ]);

        if($request->image === null){

            return response()->json(['status' => 'kepala bana']);

        }

        $product = $this->productRepository->findProductById($request->product_id);

        foreach($request->image as $image){

            $image = $this->uploadOne($image, 'products');

            $productImage = new ProductImage([
                'full'      =>  $image,
            ]);

            $product->images()->save($productImage);

        }

        return response()->json(['status' => 'Success']);
    }

    public function delete($id)
    {
        $image = ProductImage::findOrFail($id);

        if ($image->full != '') {
            $this->deleteOne($image->full);
        }

        $image->delete();

        return response()->json(['status' => 'Success']);
    }
}
