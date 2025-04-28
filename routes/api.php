<?php

use App\Http\Controllers\API\EmployeeController;
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

Route::apiResource('employees', 'API\EmployeeController');
Route::apiResource('request-products', 'API\RequestProductController');
Route::apiResource('products', 'API\ProductController');
Route::get('departements', [EmployeeController::class, 'getDepartements']);
Route::get('get-employe-by-nik/{id}', [EmployeeController::class, 'getEmployeeByNik']);