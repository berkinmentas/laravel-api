<?php

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/hello', function (){
   return "Hello RESTful API";
});


Route::get('/users', function (){
    return   Product::factory()->count(10)->create();
});


//Route::apiResource('/products', \App\Http\Controllers\Api\ProductController::class);
//Route::apiResource('/users', \App\Http\Controllers\Api\UserController::class);
//Route::apiResource('/categories', \App\Http\Controllers\Api\CategoryController::class);

//Üstteki ve alttaki routes tanımı aynı görevi görüyor.

Route::get('categories/custom1', 'App\Http\Controllers\Api\CategoryController@custom1');
Route::get('products/custom1', 'App\Http\Controllers\Api\ProductController@custom1');
Route::get('products/custom2', 'App\Http\Controllers\Api\ProductController@custom2');
Route::get('categories/report1', 'App\Http\Controllers\Api\CategoryController@report1');
Route::get('users/custom1', 'App\Http\Controllers\Api\UserController@custom1');

Route::get('products/custom3', 'App\Http\Controllers\Api\ProductController@custom3');
Route::get('products/listWithCategories', 'App\Http\Controllers\Api\ProductController@listWithCategories');



Route::apiResources([
    'products'=>'\App\Http\Controllers\Api\ProductController',
    'users'=>'\App\Http\Controllers\Api\UserController',
    'categories' => '\App\Http\Controllers\Api\CategoryController'
 ]);
