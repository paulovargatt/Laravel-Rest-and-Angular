<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{

    public function register(Request $request){
      return   'OLA LOgin';
    }

    public function login(Request $request){
        echo 'OLA LOgin'; die();
    }

}
