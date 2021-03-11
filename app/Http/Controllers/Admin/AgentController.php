<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;

class AgentController extends BaseController
{
    public function commissions(){

        $this->setPageTitle('Agent Commissions', 'Manage Agent Commissions');
        return view('admin.agent.commissions.index');

    }

    public function index(){

        $agents = User::where('status', 'personal_shopper_2')->get();

        $this->setPageTitle('Agents', 'List of all agent');
        return view('admin.agent.users.index', compact('agents'));

    }

    public function view($id){

        $agent = User::findOrFail($id);

        $orders = Order::where('user_id', $id)->orderBy('created_at', 'DESC')->paginate(10);

        $this->setPageTitle('Agent', 'View Commission : '.$agent->name);

        return view('admin.agent.users.view', compact('agent', 'orders'));

    }
}
