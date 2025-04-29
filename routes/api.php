<?php

use App\Http\Controllers\API\EmployeeController;
use App\Http\Controllers\API\LocationController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\UnitController;
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
Route::apiResource('departments', 'API\DepartmentController');
Route::apiResource('request-products', 'API\RequestProductController');
Route::apiResource('locations', 'API\LocationController');
Route::apiResource('units', 'API\UnitController');
Route::apiResource('products', 'API\ProductController');
Route::get('getDepartements', [EmployeeController::class, 'getDepartements']);
Route::get('getProducts', [ProductController::class, 'getProducts']);
Route::get('getUnits', [UnitController::class, 'getUnits']);
Route::get('getLocations', [LocationController::class, 'getLocations']);
Route::get('get-employe-by-nik/{id}', [EmployeeController::class, 'getEmployeeByNik']);