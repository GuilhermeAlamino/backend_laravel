<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', function () {
    return response()->json(['api_name' => 'laravel-jwt', 'api-version' => '1.0.0']);
});

Route::post('/login', 'AuthController@login');

Route::group(['middleware' => 'verify.token'], function () {

    // Rotas de jwt
    Route::post('/user', 'AuthController@user');

    Route::post('/logout', 'AuthController@logout');


    //employee
    Route::get('/employee', 'EmployeeController@index');

    Route::get('/employee/{id}', 'EmployeeController@show');

    Route::post('/employee', 'EmployeeController@store');

    Route::put('/employee/{id}', 'EmployeeController@update');

    Route::delete('/employee/{id}', 'EmployeeController@delete');
   
    //department
    Route::get('/department', 'DepartmentController@index');

    Route::get('/department/{id}', 'DepartmentController@show');

    Route::post('/department', 'DepartmentController@store');

    Route::put('/department/{id}', 'DepartmentController@update');

    Route::delete('/department/{id}', 'DepartmentController@delete');
   
    //task
    Route::get('/task', 'TaskController@index');

    Route::get('/task/{id}', 'TaskController@show');

    Route::post('/task', 'TaskController@store');

    Route::put('/task/{id}', 'TaskController@update');

    Route::delete('/task/{id}', 'TaskController@delete');

});
