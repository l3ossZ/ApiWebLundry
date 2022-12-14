<?php

use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\MemberPackageController;
use App\Http\Controllers\Api\OrderController;
use App\Models\DeliveryTime;
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
use App\Models\Order;

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
Route::post('/orders/{order}/clothList',[OrderController::class,'storeClothList']);
Route::get('/customers/searchE',[CustomerController::class, 'searchEmail']);
// Route::get('/rewards/search', [\App\Http\Controllers\Api\RewardController::class, 'search']);
// Route::get('/reward_codes/search', [\App\Http\Controllers\Api\RewardCodeController::class, 'search']);
Route::get('/customers/search',[CustomerController::class,'search']);
Route::put('/laundry/{laundry}/open',[LaundryController::class,'openLaundry']);
Route::put('/laundry/{laundry}/close',[LaundryController::class,'closeLaundry']);
Route::get('/laundry/{laundry}/getStatus',[LaundryController::class,'getStatus']);
Route::get('/category/getCategoryByService',[CategoryController::class,'getCategoryByService']);
Route::get('/customers/{customer}/getOrderOfCustomer',[CustomerController::class,'getOrderOfCustomer']);
Route::get('/customers/getOrderOfCustomerAuth',[CustomerController::class,'getOrderOfCustomerAuth']);
Route::delete('/orders/{order}/clothList/{clothList}',[OrderController::class,'deleteClothList']);
Route::get("/orders/getOrderWeek",[OrderController::class,'getOrderWeek']);
Route::get("/orders/getOrderMonth",[OrderController::class,'getOrderMonth']);
Route::get("/orders/getOrderYear",[OrderController::class,'getOrderYear']);

Route::put('/orders/{order}/clothList/{clothList}',[OrderController::class,'editClothList']);
Route::get('/orders/{order}/generateQr',[OrderController::class,'generateQr']);
Route::put('/orders/{order}/payStatus',[OrderController::class,'payStatus']);
Route::put('/orders/{order}/nextStatus',[OrderController::class,'nextStatus']);
Route::get('/customers/{customer}/getCustomerAddress',[CustomerController::class,'getCustomerAddress']);
Route::get('/customers/getCustomerAddressAuth',[CustomerController::class,'getCustomerAddressAuth']);
Route::put('/customers/{customer}/addMemberService',[CustomerController::class,'addMemberService']);
Route::put("/customers/{customer}/payMember",[CustomerController::class,'payMember']) ;
//Route::get('/customers/getNumOfCustomer',[CustomerController::class,'getNumOfCustomer']);
//Route::get('/customers/getNumOfMember',[CustomerController::class,'getNumOfMember']);
Route::get('laundry/{laundry}/getName',[LaundryController::class,'getName']);
Route::put('orders/{order}/storeDeliveryTime',[OrderController::class,'storeDeliveryTime']);
Route::put('orders/{order}/cancelDeliveryTime',[OrderController::class,'cancelDeliveryTime']);
Route::put('orders/{order}/storePickTime',[OrderController::class,'storePickTime']);
Route::put('orders/{order}/cancelPickTime',[OrderController::class,'cancelPickTime']);
Route::put('orders/{order}/acceptOrderForEmployee',[OrderController::class,'acceptOrderForEmployee']);
Route::put('orders/{order}/acceptOrderForDeliver',[OrderController::class,'acceptOrderForDeliver']);
Route::get('/orders/getTodayOrder',[OrderController::class,'getTodayOrder']);
Route::get('/orders/getDashboardData',[OrderController::class,'getDashboardData']);
Route::put('orders/{order}/cancelOrder',[OrderController::class,'cancelOrder']);
Route::put('/orders/{order}/calDeliApp',[OrderController::class,'calDeliApp']);
Route::put('/orders/{order}/updateAppOrder',[OrderController::class,'updateAppOrder']);

Route::put('/employees/changePassword',[EmployeeController::class,'changePassword']);

Route::post('/orders/getPreviewClothList',[OrderController::class,'getPreviewClothList']);
Route::post('/orders/getReport',[OrderController::class,'getReport']);
Route::post('/orders/getOrders',[OrderController::class,'getOrderWithAuth']);
Route::put('/orders/{order}/updateStatus',[OrderController::class,'updateStatus']);
Route::post('/address/getAddress',[AddressController::class,'getAddressWithAuth']);


//Route::get('/orders/getIncomeToday',[OrderController::class,'getIncomeToday']);
//Route::get('/orders/getNumOfCompleteOrder',[OrderController::class,'getNumOfCompleteOrder']);
//Route::get('/orders/getNumOfInprogressOrder',[OrderController::class,'getNumOfInprogressOrder']);
//Route::get('/orders/getNumOfNotPayOrder',[OrderController::class,'getNumOfNotPayOrder']);


// Route::apiResource('/rewards', \App\Http\Controllers\Api\RewardController::class);
// Route::apiResource('/reward_codes', \App\Http\Controllers\Api\RewardCodeController::class);
Route::put('/delivery-time/getNumOfWork',[DeliveryTimeController::class,'getNumOfWork']);
Route::put('/delivery-time/getAvailableInDateTime',[DeliveryTimeController::class,'getAvailableInDateTime']);
Route::put('/delivery-time/{deliveryTime}/addDeliver',[DeliveryTimeController::class,'addDeliver']);
Route::put('/delivery-time/{deliveryTime}/cancelDelivery',[DeliveryTimeController::class,'cancelDelivery']);
Route::get('/delivery-time/getDeliveryListToday',[DeliveryTimeController::class,'getDeliveryListToday']);
//Route::put('delivery-time/{deliveryTIme}/editDeliverTime',[DeliveryTimeController::class,'editDeliverTime']);
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
Route::apiResource('/member-package',MemberPackageController::class);
Route::put('/customers/{customer}/registerOldCustomer',[CustomerController::class,'registerOldCustomer']);





Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('getOldCustomerId',[AuthController::class,'getOldCustomerId']);
    Route::post('me', [AuthController::class, 'me']);
    Route::post('customerGetMe',[AuthController::class,'customerGetMe']);
});
// Route::group(['middleware'=>'auth:sanctum'],function(){

// });
