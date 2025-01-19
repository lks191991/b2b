<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\API\CommonController;
use App\Http\Controllers\API\MasterApisController;

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


//Route::post('change_password', [RegisterController::class, 'changepassword']);     
Route::post('voucher-price-update', [CommonController::class, "voucherPriceUpdate"])->name('voucherPriceUpdate');
Route::post('get-agent', [MasterApisController::class, "getAgent"])->name('getAgent');
Route::post('create-voucher', [MasterApisController::class, "createVoucher"])->name('createVoucher');

Route::middleware(['auth:api'])->group(function () {
	Route::post('get-activity-list', [MasterApisController::class, "getActivityList"])->name('getActivityList');
	Route::post('get-variant-list', [MasterApisController::class, "getVariantList"])->name('getVariantList');
	Route::post('get-activity-variant-list', [MasterApisController::class, "getActivityVariantList"])->name('getActivityVariantList');
});

Route::fallback(function(){
    return response()->json(['data'=>new \stdClass(), 'message' => 'Page Not Found. If error persists, contact info@myquip.com', 'statusCode' => 404], 404);
});