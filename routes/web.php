<?php

Route::get('/', function () {
    return view('welcome');
});


Route::post('/api/register', 'UserController@register');
Route::post('/api/login', 'UserController@login');
Route::resource('/api/cars', 'CarController');