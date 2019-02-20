<?php

use Illuminate\Http\Request;

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
Route::group(["namespace" => "API", "as" => "api."], function () {
    Route::patch("users/{user}/restore", "UserController@restore");
    Route::resource("users", "UserController", ["except" => ["create", "edit"]]);
    Route::patch("categories/{category}/restore", "CategoryController@restore");
    Route::resource("categories", "CategoryController", ["except" => ["create", "edit"]]);
    Route::patch("products/{product}/restore", "ProductController@restore");
    Route::resource("products", "ProductController", ["except" => ["create", "edit"]]);
    Route::resource("products.categories", "ProductCategoryController", ["only" => ["index", "store", "destroy"]]);
    Route::resource("products.inputs", "ProductInputController", ["only" => ["index", "store", "show"]]);
    Route::resource("products.outputs", "ProductOutputController", ["only" => ["index", "store", "show"]]);
    Route::resource("products.photos", "ProductPhotoController", ["except" => ["create", "edit"]]);
});
