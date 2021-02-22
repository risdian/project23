<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AgentController extends BaseController
{
    public function commissions(){

        $this->setPageTitle('Agent Commissions', 'Manage Agent Commissions');
        return view('admin.agent.commissions.index');

    }
}
