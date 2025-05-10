<?php

use App\Http\Controllers\dmtinstantpayController;
use App\Http\Controllers\infoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KycController;
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



Route::get('/admin/kyc-list', [KycController::class, 'getAllData'])->name('admin.kyc-list');
Route::get('/transcation/list', [infoController::class, 'indexAdminAPI']);
Route::get('/pending/transcation/list', [dmtinstantpayController::class, 'pendingTransaction_api']);
Route::post('/receive-pending/data',[dmtinstantpayController::class,'pendingResponse']);


