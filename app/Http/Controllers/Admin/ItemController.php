<?php

namespace App\Http\Controllers\Admin;

use App\Models\Item;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Contracts\ItemContract;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Models\Branch;

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

        $items = Item::all();

        $this->setPageTitle('Items', 'List of all items');
        return view('admin.items.index', compact('items'));

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        // $products = Product::all();

        // $this->setPageTitle('Items', 'Create Item');
        // return view('admin.items.create', compact('products'));

        $branches = Branch::All();

        $this->setPageTitle('Items', 'Create Item');

        return view('admin.items.create', compact('branches'));
    }

    public function subCat(Request $request){

        $branch_id = $request->bran_id;

        $products = Branch::where('id', $branch_id)->with('products')->get();
        // dd($subcategories);
        return response()->json([

            'products' => $products

        ]);

    }

    public function store(Request $request){

        $this->validate($request, [
            'product_id'      =>  'required|max:191',
            'image'     =>  'required|mimes:jpg,jpeg,png|max:1000'
        ]);

        $params = $request->except('_token');

        $item = $this->itemRepository->createItem($params);

        if (!$item) {
            return $this->responseRedirectBack('Error occurred while updating item.', 'error', true, true);
        }
        return $this->responseRedirect('admin.items.index', 'item update successfully' ,'success',false, false);

    }

    public function edit($id){

        $item = $this->itemRepository->findItemById($id);
        $branches = Branch::All();


        $this->setPageTitle('Items', 'Edit Item : '.$item->product->name);
        return view('admin.items.edit', compact('item', 'branches'));

    }

    public function update(Request $request){

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
                    'message' => 'Unauthorized'
                ], 401);
            }
        }

        $params = $request->except('_token');

        $item = $this->itemRepository->updateItem($params);

        if (!$item) {
            return $this->responseRedirectBack('Error occurred while creating item.', 'error', true, true);
        }
        return $this->responseRedirect('admin.items.index', 'item added successfully' ,'success',false, false);


    }

    public function delete(){


    }
}
