<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;

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


Route::get('item/all/filtered', [ItemController::class, 'getAllItemsFiltered']);
Route::get('itemcategory/all', [ItemController::class, 'getAllItemcategories']);
Route::post('login', [UserController::class, 'login']);

Route::group(['middleware' => 'jwt.auth'], function () {
	Route::get('item/list', [ItemController::class, 'getItemWhenLogin']);
	Route::get('item/posted', [ItemController::class, 'getItemPostedWhenLogin']);
	Route::get('item/detail', [ItemController::class, 'getItemDetail']);
	Route::post('item/bid', [ItemController::class, 'bidItem']);
});