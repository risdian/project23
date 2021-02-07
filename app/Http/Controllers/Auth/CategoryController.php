<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Contracts\CategoryContract;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;

class CategoryController extends BaseController
{
    /**
     * @var CategoryContract
     */
    protected $categoryRepository;

    /**
     * CategoryController constructor.
     * @param CategoryContract $categoryRepository
     */
    public function __construct(CategoryContract $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $categories = $this->categoryRepository->listCategories();

        return response()->json($categories);

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
            'parent_id' =>  'required|not_in:0',
            // 'image'     =>  'mimes:jpg,jpeg,png|max:1000'
        ]);

        $params = $request->except('_token');

        $category = $this->categoryRepository->createCategory($params);

        if (!$category) {
            return response()->json([
                'message' => 'Error occurred while creating category.'
            ], 201);
        }
        return response()->json([
            'message' => 'Category added successfully'
        ], 201);

    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $targetCategory = $this->categoryRepository->findCategoryById($id);
        // $categories = $this->categoryRepository->listCategories();

        $categories = $this->categoryRepository->treeList();

        return response()->json([
            'parent' => $targetCategory->name,
            'category' => $categories
        ]);

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
            'parent_id' =>  'required|not_in:0',
            // 'image'     =>  'mimes:jpg,jpeg,png|max:1000'
        ]);

        $params = $request->except('_token');

        $category = $this->categoryRepository->updateCategory($params);

        if (!$category) {
            return response()->json([
                'message' => 'Error occurred while updating category.'
            ], 201);
        }
        return response()->json([
            'message' => 'Category updating successfully'
        ], 201);

    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $category = $this->categoryRepository->deleteCategory($id);

        if (!$category) {
            return response()->json([
                'message' => 'Error occurred while deleting category.'
            ], 201);
        }
        return response()->json([
            'message' => 'Category deleting successfully'
        ], 201);
    }
}
