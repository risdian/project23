<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Contracts\BranchContract;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;

class BranchController extends BaseController
{
    /**
     * @var BranchContract
     */
    protected $branchRepository;

    /**
     * BranchController constructor.
     * @param BranchContract $brandRepository
     */
    public function __construct(BranchContract $branchRepository)
    {
        $this->branchRepository = $branchRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $branches = $this->branchRepository->listBranches();

        $this->setPageTitle('Branch', 'List of all branches');
        return view('admin.branches.index', compact('branches'));
    }

    public function create(){

        $this->setPageTitle('Branch', 'Create Branch');
        return view('admin.branches.create');

    }

    public function store(Request $request){

        $this->validate($request, [
            'name'      =>  'required|max:191',
            'address'   =>  'required|max:191',
            'postcode'  =>  'required|max:191',
            'city'      =>  'required|max:191',
            'state'     =>  'required|max:191',
            'country'   =>  'required|max:191',

        ]);

        $params = $request->except('_token');

        $branch = $this->branchRepository->createBranch($params);

        if (!$branch) {
            return $this->responseRedirectBack('Error occurred while creating branch.', 'error', true, true);
        }
        return $this->responseRedirect('admin.branches.index', 'Branch added successfully' ,'success',false, false);

    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $branch = $this->branchRepository->findBranchById($id);

        $this->setPageTitle('Branch', 'Edit Brancj : '.$branch->name);
        return view('admin.branches.edit', compact('branch'));
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
            'address'   =>  'required|max:191',
            'postcode'  =>  'required|max:191',
            'city'      =>  'required|max:191',
            'state'     =>  'required|max:191',
            'country'   =>  'required|max:191',

        ]);

        $params = $request->except('_token');

        $branch = $this->branchRepository->updateBranch($params);

        if (!$branch) {
            return $this->responseRedirectBack('Error occurred while updating branch.', 'error', true, true);
        }
        return $this->responseRedirectBack('Branch updated successfully' ,'success',false, false);
    }


}
