<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Contracts\BranchContract;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Models\Branch;

class BranchController extends BaseController
{
    /**
     * @var BranchContract
     */
    protected $branchRepository;

    /**
     * BranchController constructor.
     * @param BranchContract $branchRepository
     */
    public function __construct(BranchContract $branchRepository)
    {
        $this->branchRepository = $branchRepository;
    }

    public function index(Request $request){

        $branches = Branch::all();

        return response()->json($branches);

    }

    public function getBranch($id){

        $branch = Branch::findorfail($id);

        return response()->json($branch);

    }

}
