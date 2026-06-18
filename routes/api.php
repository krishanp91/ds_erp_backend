<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\MeasureUnitController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Validators\CreateSupplierValidator;

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

Route::post('register', 'UserController@register');
Route::post('login', [UserController::class, 'authenticate']);
Route::get('open', 'DataController@open');
Route::get('companies/{id}', [CompanyController::class, 'getCompanyDetails']);

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('user', [UserController::class, 'getAuthenticatedUser']);
    Route::get('users/permissions/{locationId}/{moduleId}', [UserController::class, 'getUserPermissionsByLocationAndModule']);

    //permissions routes
    Route::get('permissions/{locationId}/{moduleId}', [PermissionController::class, 'getPermissionsForMenu']);

    //category routes
    Route::post('categories', [CategoryController::class, 'createCategory']);
    Route::get('categories', [CategoryController::class, 'getAllCategories']);
    Route::get('categories/active', [CategoryController::class, 'getActiveCategories']);
    Route::get('categories/{id}', [CategoryController::class, 'getCategory']);
    Route::put('categories/{id}', [CategoryController::class, 'updateCategory']);
    Route::delete('categories/{id}', [CategoryController::class, 'deleteCategory']);
    Route::put('categories/{id}/active', [CategoryController::class, 'activateCategory']);

    //product routes
    Route::post('products', [ProductController::class, 'createProduct']);
    Route::get('products', [ProductController::class, 'getAllProducts']);
    Route::get('products/active', [ProductController::class, 'getActiveProducts']);
    Route::get('products/{id}', [ProductController::class, 'getProduct']);
    Route::put('products/{id}', [ProductController::class, 'updateProduct']);
    Route::delete('products/{id}', [ProductController::class, 'deleteProduct']);
    Route::put('products/{id}/active', [ProductController::class, 'activateProduct']);

    //measure unit routes
    Route::post('measure-units', [MeasureUnitController::class, 'createUnit']);
    Route::get('measure-units', [MeasureUnitController::class, 'getAllMeasureUnits']);
    Route::get('measure-units/{id}', [MeasureUnitController::class, 'getMeasureUnit']);
    Route::put('measure-units/{id}', [MeasureUnitController::class, 'updateMeasureUnit']);
    Route::delete('measure-units/{id}', [MeasureUnitController::class, 'deleteMeasureUnit']);

    //supplier routes
    Route::post('suppliers', [SupplierController::class, 'createSupplier'])->middleware([
        CreateSupplierValidator::class
    ]);
});
