<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Mail\Contact;
use Illuminate\Support\Str;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use App\Mail\InvitationEmail;
use App\Services\ToyyibPayService;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
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


        $roles = Role::all();

        $this->setPageTitle('Users', 'Create User');

        return view('admin.users.create', compact('roles'));

    }

    public function store(Request $request){

        $this->validate($request, [
            'name'          =>  'required|max:191',
            'nric'          =>  'required|regex:/^\d{6}-\d{2}-\d{4}$/|unique:users',
            'mobile'        =>  'required|regex:/^(\+?6?01)[0-46-9]-*[0-9]{7,8}$/|unique:users',
            'email'         =>  'required|string|email|max:255|unique:users',
            'roles'         =>  'required',
        ]);

        $user = new User;

        $user->name = $request->name;
        $user->nric = $request->nric;
        $user->mobile = $request->mobile;
        $user->email = $request->email;
        $user->password = bcrypt('Smsgvs32!@#$');
        $user->status = 'sale_expert';

        $user->save();

        $user->assignRole($request->input('roles'));

        $token = app(\Illuminate\Auth\Passwords\PasswordBroker::class)->createToken($user);

        Mail::to($user->email)
            ->send(new Contact($user->name, $token, $user->email));

        if (!$user) {
            return $this->responseRedirectBack('Error occurred while creating user.', 'error', true, true);
        }
        return $this->responseRedirect('admin.users.index', 'User added successfully' ,'success',false, false);

    }

    public function complete(){

        return 'payment complete';

    }

    public function payment_update(){

        return 'payment update';

    }

    public function edit($id){

        $roles = Role::all();
        $user = User::findorFail($id);
        $userRole = $user->roles->pluck('id')->first();
        $this->setPageTitle('Users', 'Edit User : '.$user->name);
        return view('admin.users.edit', compact('user', 'roles', 'userRole'));

    }

    public function update(Request $request){

        $this->validate($request, [
            'name'          =>  'required|max:191',
            'nric'          =>  'required|regex:/^\d{6}-\d{2}-\d{4}$/|unique:users,nric,'.$request->id,
            'mobile'        =>  'required|regex:/^(\+?6?01)[0-46-9]-*[0-9]{7,8}$/|unique:users,mobile,'.$request->id,
            'email'         =>  'required|string|email|max:255|unique:users,email,'.$request->id,
            'roles'         =>  'required',
        ]);

        $user = User::findorFail($request->id);

        $user->name = $request->name;
        $user->nric = $request->nric;
        $user->mobile = $request->mobile;
        $user->email = $request->email;

        $user->save();

        DB::table('model_has_roles')->where('model_id',$request->id)->delete();

        $user->assignRole($request->input('roles'));

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
