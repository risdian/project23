<?php

namespace App\Http\Controllers\Auth;

use App\Models\Item;
use App\Models\Branch;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Contracts\ItemContract;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;

class ItemController extends BaseController
{
    /**
     * @var ItemContract
     */
    protected $itemRepository;

    /**
     * BrandController constructor.
     * @param ItemContract $itemRepository
     */
    public function __construct(ItemContract $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    public function index(){

        // $items = Product::whereIn('id',
        //     Item::select('product_id')
        //     ->where('user_id', Auth::user()->id)
        //     ->get())
        // ->get();


        $items = Item::where('user_id',  Auth()->user()->id)->with('product')->get();

        return response()->json($items);

    }

    public function products(){

        $items = Product::whereIn('id',
                Item::select('product_id')
                ->where('user_id', Auth::user()->id)

                ->get()
                )->with('category', 'branch', 'images')
            ->get();

        return response()->json($items);

    }

    public function findItem(Request $request){

        $item = Item::where('user_id', Auth()->user()->id)->where('product_id', $request->product_id)->first();

        if($item != null){

            return response()->json([
                'item'         =>      'exist',]);
        }else{
            return response()->json([
                'item'         =>      'empty',]);

        }


    }


    public function subCat($id){

        $branch = Branch::findOrFail($id);
        // dd($subcategories);

        $products = $branch->products()->get();
        return response()->json(

            $products

        );

    }


    public function store(Request $request){

        $this->validate($request, [
            'product_id'      =>  'required|max:191',
            'image'           =>  'mimes:jpg,jpeg,png|max:1000'
        ]);

        $item = Item::where('user_id', auth()->user()->id)->where('product_id', $request->product_id)->get();

        if($item->isNotEmpty()){
            return response()->json([
                'message' => 'Product already exist'
            ], 401);
        }

        $params = $request->except('_token');

        $item = $this->itemRepository->createItem($params);

        if (!$item) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
        return response()->json([
            'message' => 'Item added successfully'
        ], 201);

    }

    public function edit($id){

        $item = Item::findOrFail($id);

        $product = $item->product->name;
        return response()->json([
            'item' => $item,
            'product' => $product
        ]);

    }

    public function update(Request $request){

        // return $request->all();

        $this->validate($request, [
            'product_id'        =>  'required|max:191',
            'image'             =>  'mimes:jpg,jpeg,png|max:1000'
        ]);

        //new item tak sama dengan current item
        //check

        $existing_item = $this->itemRepository->findItemById($request->id);

        if($existing_item->product_id !== $request->product_id){

            $item = Item::where('user_id', auth()->user()->id)->where('product_id', $request->product_id)->get();
            if($item->isNotEmpty()){
                return response()->json([
                    'message' => 'Product already Exist'
                ], 401);
            }
        }

        $params = $request->except('_token');

        $item = $this->itemRepository->updateItem($params);
        return 'babi';

    }

    public function add(Request $request){


        $item = new Item;

        $item->user_id = Auth()->user()->id;
        $item->product_id = $request->product_id;

        $item->save();

        // return response()->json($item);


         if (!$item) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
        return response()->json([
            'message' => 'Item added successfully'
        ], 201);

    }

    public function remove($id){

        $item = Item::where('user_id', Auth()->user()->id)->where('product_id', $id)->first();

        $item->delete();

        if (!$item) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
        return response()->json([
                'message' => 'Item delete successfully'
            ], 201);

    }

}
