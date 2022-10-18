<?php

use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\DeliveryTimeController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\InvoiceReceiptController;
use App\Http\Controllers\Api\LaundryController;
use App\Http\Controllers\Api\OrderController as ApiOrderController;
use App\Http\Controllers\Api\ServiceRateController;
use App\Http\Controllers\Api\CustomerHasAddressController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/', function () {
    return [
        'version' => '1.0.0'
    ];
});
Route::post('/orders/storeWithPhone',[OrderController::class,'storeWithPhone']);
// Route::post('/orders/{order}/make-inv',[OrderController::class,'makeInvoice']);
Route::post('/orders/{order}/cloth-list',[OrderController::class,'storeClothList']);
Route::get('/customers/searchE',[CustomerController::class, 'searchEmail']);
Route::get('/rewards/search', [\App\Http\Controllers\Api\RewardController::class, 'search']);
Route::get('/reward_codes/search', [\App\Http\Controllers\Api\RewardCodeController::class, 'search']);
Route::get('/customers/search',[CustomerController::class,'search']);
Route::apiResource('/rewards', \App\Http\Controllers\Api\RewardController::class);
Route::apiResource('/reward_codes', \App\Http\Controllers\Api\RewardCodeController::class);
Route::apiResource('/orders',ApiOrderController::class);
Route::apiResource('/customers',CustomerController::class);
Route::apiResource('/address',AddressController::class);
Route::apiResource('/service-rate',ServiceRateController::class);
Route::apiResource('/laundry',LaundryController::class);
Route::apiResource('/category',CategoryController::class);
Route::apiResource('/employees',EmployeeController::class);
Route::apiResource('/delivery-time',DeliveryTimeController::class);
Route::apiResource('/invoice-receipt',InvoiceReceiptController::class);
Route::apiResource('/customer_has_address',CustomerHasAddressController::class);




Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});
// Route::group(['middleware'=>'auth:sanctum'],function(){

// });
