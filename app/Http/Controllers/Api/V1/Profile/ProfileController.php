<?php

namespace App\Http\Controllers\Api\V1\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Hash;
use Auth;

class ProfileController extends Controller{
    public function get(Request $request){
        return $this->success('Berhasil',$request->user());
    }

    public function update(Request $request){
    	$user 			= $request->user();
        $data_update 	= $request->all();
        if (isset($request->email)) {
        	if (User::where('email', $request->email)->where('id','!=',$user->id)->count() > 0) {
        		return $this->failure('Email has already been taken');
        	}
        }
        if (isset($request->phone)) {
        	if (User::where('phone', $request->phone)->where('id','!=',$user->id)->count() > 0) {
        		return $this->failure('Phone number has already been taken');
        	}
        }
        try { 
          	User::find($user->id)->update($data_update);
        } catch(\Illuminate\Database\QueryException $ex){ 
          	return $this->failure();
        }
        $user = User::where('id', $user->id)->first();
        return $this->success('Update successful',$user);
    }

    public function changePassword(Request $request){
        $validator = $this->customValidation($request, [
            'old_password' =>  'required|string',
            'new_password' => 'required|string',
            'new_password_confirmation' => 'required|string|same:new_password',
        ]);
        if ($validator !== TRUE) {
            return $validator;
        }
        $user       = User::find(Auth::id());       
        if($user){
            if (Hash::check($request->old_password, $user->password)) {
                $user->password = $request->new_password;
                $user->save();
                return $this->success('Kata sandi berhasil berhasil diperbarui.');
            } else {
                return $this->failure('Kata sandi lama tidak sesuai.');
            }
        }
        else{
            return $this->failure('User tidak ditemukan');
        }
    }
}
