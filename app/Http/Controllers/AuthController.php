<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\User;
//use Dotenv\Validator as Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
//use Validator;
use Illuminate\Support\Facades\Validator;


class AuthController extends BaseController
{
    public function register(Request $request){
          $validator= Validator::make($request->all(),[
              'name'=>'required',
              'email'=>'required|email',
              'password'=>'required',
              'c_password'=>'required|same:password'
          ]);
          if ($validator->fails()) {
              return $this->sendError('validate error', $validator->errors());
          }

          $input= $request->all();
          $input['password']=Hash::make($input['password']);
          $user=User::create($input);
          $success['token']=$user->createToken('lis')->accessToken;
          $success['name']=$user->name;
          return $this->sendResponse($success, 'user registered successfully!');

    }


    public function login(Request $request){

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            /** @var \App\Models\MyUserModel $user **/
           $user=Auth::user();
           $success['token']=$user->createToken('lis')->accessToken;
           $success['name']=$user->name;
           return $this->sendResponse($success, 'user logged in successfully!');
 
        }
        
        else {
            return $this->sendError('login failed', ['error','login failed']);
        }

  }
}
