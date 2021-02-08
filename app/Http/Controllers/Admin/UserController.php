<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Mail\Contact;
use Illuminate\Support\Str;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use App\Mail\InvitationEmail;
use App\Services\ToyyibPayService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\BaseController;

class UserController extends BaseController
{
    protected $toyyibPay;

    public function __construct(ToyyibPayService $toyyibPay)
    {
        $this->toyyibPay = $toyyibPay;
    }

    public function index(){

        $users = User::all();

        $this->setPageTitle('Users', 'User List');
        return view('admin.users.index', compact('users'));

    }

    public function create(){

        $this->setPageTitle('Users', 'Create User');
        return view('admin.users.create');

    }

    public function store(Request $request){

        $this->validate($request, [
            'name'          =>  'required|max:191',
            'country_code'  =>  'required',
            'mobile'        =>  'required',
            'email'         => 'required|string|email|unique:users',
        ]);

        $user = new User;

        $user->name = $request->name;
        $user->country_code = $request->country_code;
        $user->mobile = $request->mobile;
        $user->email = $request->email;
        $user->password = bcrypt('password');
        $user->status = 'sale_expert';
        $user->save();

        // $this->toyyibPay->processPayment($user);

        // $token = app(\Illuminate\Auth\Passwords\PasswordBroker::class)->createToken($user);


        // Mail::to($user->email)
        //     ->send(new Contact($user->name, $token, $user->email));

        // if (!$user) {
        //     return $this->responseRedirectBack('Error occurred while creating user.', 'error', true, true);
        // }
        // return $this->responseRedirect('admin.users.index', 'User added successfully' ,'success',false, false);

    }

    public function complete(){

        return 'payment complete';

    }

    public function payment_update(){

        return 'payment update';

    }

    public function edit($id){

        $user = User::findorFail($id);

        $this->setPageTitle('Users', 'Edit User : '.$user->name);
        return view('admin.users.edit', compact('user'));

    }

    public function update(Request $request){

        $this->validate($request, [
            'name'          =>  'required|max:191',
            'country_code'  =>  'required',
            'mobile'        =>  'required',
            'email'         =>  'required|string|email|max:255|unique:users,email,'.$request->id,
        ]);

        $user = User::findorFail($request->id);

        // return $user;

        $user->name = $request->name;
        $user->country_code = $request->country_code;
        $user->mobile = $request->mobile;
        $user->email = $request->email;
        $user->save();

        if (!$user) {
            return $this->responseRedirectBack('Error occurred while update user.', 'error', true, true);
        }
        return $this->responseRedirect('admin.users.index', 'User update successfully' ,'success',false, false);
    }

    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
}
