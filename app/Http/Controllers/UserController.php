<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;


class UserController extends Controller
{

    public function register(Request $request){
      $json = $request->input('json', null);
      $params = json_decode($json);

      $email = (!is_null($json) && isset($params->email)) ? $params->email : null;
      $name = (!is_null($json) && isset($params->name)) ? $params->name : null;
      $lastname = (!is_null($json) && isset($params->lastname)) ? $params->lastname : null;
      $role = 'ROLE_USER';
      $password =  (!is_null($json) && isset($params->password)) ? $params->password : null;


      if(!is_null($email) && !is_null($password) && !is_null($name)){
          //create
          $user = new User();
          $user->email = $email;
          $user->name = $name;
          $user->lastname = $lastname;
          $user->role = $role;

          $pwd = bcrypt($password);
          $user->password = $pwd;
          // validate duplicate
          $isset_user = User::where('email', '=',$email)->first();
          if(count($isset_user) == 0){
               $user->save();
              $data = array(
                  'status' => 'success',
                  'code' => 200,
                  'message' => 'User created'
              );
          }else{
              $data = array(
                  'status' => 'error',
                  'code' => 400,
                  'message' => 'User dupliacate'
              );
          }

      }
      else{
          $data = array(
              'status' => 'error',
              'code' => 400,
              'message' => 'User not create'
          );
      }

        return response()->json($data,200);
    }

    public function login(Request $request){
        echo 'OLA LOgin'; die();
    }

}
