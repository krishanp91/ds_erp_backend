<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\MeasureUnitController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TaxCategoryController;
use App\Http\Controllers\TaxCategoryTaxController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\UserController;

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
Route::post('refresh', [UserController::class, 'refresh']);
Route::get('open', 'DataController@open');
Route::get('companies/{id}', [CompanyController::class, 'getCompanyDetails']);

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::post('logout', [UserController::class, 'logout']);
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

    //tax routes
    Route::post('taxes', [TaxController::class, 'createTax']);
    Route::get('taxes', [TaxController::class, 'getAllTaxes']);
    Route::get('taxes/active', [TaxController::class, 'getActiveTaxes']);
    Route::get('taxes/{id}', [TaxController::class, 'getTax']);
    Route::put('taxes/{id}', [TaxController::class, 'updateTax']);
    Route::delete('taxes/{id}', [TaxController::class, 'deleteTax']);
    Route::put('taxes/{id}/active', [TaxController::class, 'activateTax']);

    //tax category routes
    Route::post('tax-categories', [TaxCategoryController::class, 'createTaxCategory']);
    Route::get('tax-categories', [TaxCategoryController::class, 'getAllTaxCategories']);
    Route::get('tax-categories/active', [TaxCategoryController::class, 'getActiveTaxCategories']);
    Route::get('tax-categories/{id}', [TaxCategoryController::class, 'getTaxCategory']);
    Route::put('tax-categories/{id}', [TaxCategoryController::class, 'updateTaxCategory']);
    Route::delete('tax-categories/{id}', [TaxCategoryController::class, 'deleteTaxCategory']);
    Route::put('tax-categories/{id}/active', [TaxCategoryController::class, 'activateTaxCategory']);

    //tax category tax routes
    Route::post('tax-category-taxes', [TaxCategoryTaxController::class, 'createTaxCategoryTax']);
    Route::get('tax-category-taxes', [TaxCategoryTaxController::class, 'getAllTaxCategoryTaxes']);
    Route::get('tax-category-taxes/{id}', [TaxCategoryTaxController::class, 'getTaxCategoryTax']);
    Route::put('tax-category-taxes/{id}', [TaxCategoryTaxController::class, 'updateTaxCategoryTax']);
    Route::delete('tax-category-taxes/{id}', [TaxCategoryTaxController::class, 'deleteTaxCategoryTax']);
    Route::put('tax-category-taxes/{id}/active', [TaxCategoryTaxController::class, 'activateTaxCategoryTax']);

    //measure unit routes
    Route::post('measure-units', [MeasureUnitController::class, 'createUnit']);
    Route::get('measure-units', [MeasureUnitController::class, 'getAllMeasureUnits']);
    Route::get('measure-units/{id}', [MeasureUnitController::class, 'getMeasureUnit']);
    Route::put('measure-units/{id}', [MeasureUnitController::class, 'updateMeasureUnit']);
    Route::delete('measure-units/{id}', [MeasureUnitController::class, 'deleteMeasureUnit']);

    //supplier routes
    Route::post('suppliers', [SupplierController::class, 'createSupplier']);
    Route::get('suppliers', [SupplierController::class, 'getAllSuppliers']);
    Route::get('suppliers/active', [SupplierController::class, 'getActiveSuppliers']);
    Route::get('suppliers/next-code', [SupplierController::class, 'getNextSupplierCode']);
    Route::get('suppliers/{id}', [SupplierController::class, 'getSupplier']);
    Route::put('suppliers/{id}', [SupplierController::class, 'updateSupplier']);
    Route::delete('suppliers/{id}', [SupplierController::class, 'deleteSupplier']);
    Route::put('suppliers/{id}/active', [SupplierController::class, 'activateSupplier']);
});
