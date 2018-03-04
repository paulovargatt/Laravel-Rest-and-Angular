<?php

namespace App\Http\Controllers;

use App\Cars;
use App\Helpers\JwtAuth;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index(Request $request)
    {
        $cars = Cars::all()->load('user');
        return response()->json(array(
            'cars' => $cars,
            'status' => 'success'
        ),200);
    }

    public function show($id){
        $car = Cars::find($id)->load('user');

        return response()->json(array('car' => $car, 'status' => 'success'),200);
    }

    public function update($id, Request $request){
        $hash = $request->header('Authorization', null);
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($hash);

        if ($checkToken) {
            //Update
            $json = $request->input('json', null);
            $params = json_decode($json);
            $params_array = json_decode($json, true);

            //validation
            $validate = \Validator::make($params_array, [
                'title' => 'required|min:5',
                'description' => 'required',
                'price' => 'required',
                'status' => 'required',
            ]);
            if($validate->fails()){
                return response()->json($validate->errors(), 400);
            }
            //Update data
            $car = Cars::where('id', $id)->update($params_array);

            $data = array(
                'car' => $params,
                'status' => 'sucess',
                'code' => 200
            );
        }
        else{
            $data = array(
                'message' => 'Login incorreto',
                'status' => 'error',
                'code' => 300
            );
        }
        return response()->json($data,200);
    }

    public function destroy($id, Request $request){
        $hash = $request->header('Authorization', null);
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($hash);

        if ($checkToken) {
            $car = Cars::find($id);
            $car->delete();
            $data = array(
                'car' =>  $car,
                'status' => 'success',
                'code' => 200
            );
        }else{
            $data = array(
                'message' => 'Login incorreto',
                'status' => 'error',
                'code' => 400
            );
        }

        return response()->json($data,200);

    }


    public function store(Request $request)
    {
        $hash = $request->header('Authorization', null);
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($hash);

        if ($checkToken) {
            //Recupera dados
                $json = $request->input('json', null);
                $params = json_decode($json);
                $params_array = json_decode($json,true);

            //User autenticado
                $user = $jwtAuth->checkToken($hash, true);

            //validation
                    $validate = \Validator::make($params_array, [
                        'title' => 'required|min:5',
                        'description' => 'required',
                        'price' => 'required',
                        'status' => 'required',
                    ]);
                    if($validate->fails()){
                        return response()->json($validate->errors(), 400);
                    }

            //save
                $car = new Cars();
                $car->user_id = $user->sub;
                $car->title = $params->title;
                $car->description = $params->description;
                $car->price = $params->price;
                $car->status = $params->status;
                $car->save();

                $data = array(
                    'car' => $car,
                    'status' => 'success',
                    'code' => 200
                );
        }
        else{
            $data = array(
                'message' => 'Login incorreto',
                'status' => 'error',
                'code' => 300
            );
        }

        //global
        return response()->json($data,200);

    }


}
