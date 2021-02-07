<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function update(Request $request){

        $this->validate($request, [
            'name'          =>  'required|max:191',
            'mobile'        =>  'required',
            'email'         =>  'required|string|email|max:255|unique:users,email,'.Auth()->user()->id,
            'nric'          =>  'required'
        ]);

        $user = User::findorfail(Auth()->user()->id);

        $user->name = $request->name;
        $user->nric = $request->nric;
        $user->mobile = $request->mobile;
        $user->email = $request->email;
        $user->save();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
        return response()->json([
            'message' => 'Profile Edit successfully'
        ], 201);

    }

    public function password(Request $request){

        $this->validate($request, [
            'password'      =>  'required|string|min:8|confirmed',
        ]);

        $user = User::findorfail(Auth()->user()->id);

        $user->password = bcrypt($request->password);

        $user->save();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
        return response()->json([
            'message' => 'Password Update successfully'
        ], 201);


    }
}
