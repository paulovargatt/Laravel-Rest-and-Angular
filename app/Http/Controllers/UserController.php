<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Helpers\JwtAuth;


class UserController extends Controller
{

    public function register(Request $request)
    {
        $json = $request->input('json', null);
        $params = json_decode($json);

        $email = (!is_null($json) && isset($params->email)) ? $params->email : null;
        $name = (!is_null($json) && isset($params->name)) ? $params->name : null;
        $lastname = (!is_null($json) && isset($params->lastname)) ? $params->lastname : null;
        $role = 'ROLE_USER';
        $password = (!is_null($json) && isset($params->password)) ? $params->password : null;


        if (!is_null($email) && !is_null($password) && !is_null($name)) {
            //create
            $user = new User();
            $user->email = $email;
            $user->name = $name;
            $user->lastname = $lastname;
            $user->role = $role;

            $pwd = hash('sha256', $password);

            $user->password = $pwd;
            // validate duplicate
            $isset_user = User::where('email', '=', $email)->first();
            if (count($isset_user) == 0) {
                $user->save();
                $data = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'User created'
                );
            } else {
                $data = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'User dupliacate'
                );
            }

        } else {
            $data = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'User not create'
            );
        }

        return response()->json($data, 200);
    }

    public function login(Request $request)
    {
        $jwtAuth = new JwtAuth();

       //Post
        $json = $request->input('json', null);
        $params = json_decode($json);

        $email = (!is_null($json) && isset($params->email)) ? $params->email : null;
        $password = (!is_null($json) && isset($params->password)) ? $params->password : null;
        $getToken = (!is_null($json) && isset($params->gettoken)) ? $params->gettoken : null;

        //Crypt password
        $pwd = hash('sha256', $password);

        if(!is_null($email) && !is_null($password) && ($getToken == null || $getToken == 'false')){
            $signup = $jwtAuth->signup($email, $pwd);
        }elseif ($getToken != null){
            $signup = $jwtAuth->signup($email, $pwd, $getToken);
        }else{
           $signup = array('status' => 'error', 'message' => 'Envia os dados por post');
        }
        return response()->json($signup, 200);
    }



}
