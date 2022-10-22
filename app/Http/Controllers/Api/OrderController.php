<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ClothList;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Invoice_receipt;
use App\Models\Order;
use App\Models\ServiceRate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $orders=Order::get();
        return $orders;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $order=new Order();

        $order->service=$request->get('service');
        $order->name="ORS"."-".(string)random_int(10000,99999);
        $order->pick_date=$request->get('pick_date') ?? null;
        $order->pick_time=$request->get('pick_time') ?? null;
        $order->deli_date=$request->get('deli_date') ?? null;
        $order->deli_time=$request->get('deli_time') ?? null;
        $order->address=$request->get('address');
        $order->responder=$request->get('responder');
        $order->deliver=$request->get('deliver') ?? null;
        $order->pay_method=$request->get('pay_method') ?? "เงินสด";
        $order->pick_ser_charge=$request->get('pick_ser_charge') ?? null;
        $order->deli_ser_charge=$request->get('deli_ser_charge') ?? null;
        $order->is_membership_or=$request->get('is_membership_or') ?? false;
        $order->cus_phone=$request->get('cus_phone');

        $employee=Employee::where('name','like','%'.$request->get('responder').'%')->first();
        $order->employee_id=$employee->id;




        if ($order->save()) {

            $customer=Customer::where('phone','like','%'.$request->get('cus_phone').'%')->first();
            // $new_order=Order::where('cus_phone','like','%'.$request->get('cus_phone').'%')->first();
            // $customer->orders()->attach($new_order->id);
            $order->customers()->attach($customer->id);


            return response()->json([
                'success' => true,
                'message' => 'Order created with id ' . $order->id,
                'order_id' =>$order->id
            ],Response::HTTP_CREATED);


        }
        return response()->json([
            'success' => false,
            'message' => 'Order create failed'
        ], Response::HTTP_BAD_REQUEST);




    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {

        $clothList=$order->clothLists;

        return $order;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {


        if($request->has('service')) $order->service=$request->get('service');
        if($request->has('pick_date')) $order->pick_date=$request->get('pick_date') ?? null;
        if($request->has('pick_time')) $order->pick_time=$request->get('pick_time') ?? null;
        if($request->has('deli_date')) $order->deli_date=$request->get('deli_date') ?? null;
        if($request->has('deli_time')) $order->deli_time=$request->get('deli_time') ?? null;
        if($request->has('address')) $order->address=$request->get('address');
        if($request->has('responder')) $order->responder=$request->get('responder');
        if($request->has('deliver')) $order->deliver=$request->get('deliver') ?? null;
        if($request->has('pay_status')) $order->pay_status=$request->get('pay_status');
        if($request->has('pay_method')) $order->pay_method=$request->get('pay_method');
        if($request->has('pick_ser_charge')) $order->pick_ser_charge=$request->get('pick_ser_charge') ?? null;
        if($request->has('deli_ser_charge')) $order->deli_ser_charge=$request->get('deli_ser_charge') ?? null;
        if($request->has('status')) $order->status=$request->get('status');
        if($request->has('is_membership_or')) $order->is_membership_or=$request->get('is_membership_or');
        if($request->has('employee_id')) $order->employee_id=$request->get('employee_id');
        if($request->has('cus_phone')) $order->cus_phone=$request->get('cus_phone');
        //

        if ($order->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Order updated with id ' . $order->id,
                'order_id' =>$order->id
            ],Response::HTTP_OK);
        }
        return response()->json([
            'success' => false,
            'message' => 'Order update failed'
        ], Response::HTTP_BAD_REQUEST);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }

    public function storeClothList(Request $request, Order $order){
        $clothList=new ClothList();
        $clothList->category=$request->get('category');
        $clothList->quantity=$request->get('quantity');
        $clothList->service=$request->get('service');
        $clothList->order_id=$order->id;
        $service=ServiceRate::where('service','like','%'.$request->get('service').'%')->first();
        $service_rate_price=$service->basePrice;
        $category=Category::where('clothType','like','%'.$request->get('category').'%')->where('service_rate_id','like','%'.$service->id.'%')->first();
        $category_addOn_price=$category->addOnPrice;
        $order->total=$order->total+(($service_rate_price+$category_addOn_price)*$request->get('quantity'));

        // $clothList->service_rate_id=$service_rate->id;
        if($clothList->save()){
            $order->clothLists()->save($clothList);
            $order->save();

            return response()->json([
                'success' => true,
                'message' => 'Cloth List created with id ' . $clothList->id,
                'cloth_list_id' =>$clothList->id
            ],Response::HTTP_CREATED);
        }
        return response()->json([

            'success' => false,
            'message' => 'Cloth List created failed'
        ], Response::HTTP_BAD_REQUEST);
    }

    public function deleteClothList(Order $order,ClothList $clothList){
        $service=ServiceRate::where('service','like','%'.$clothList->service.'%')->first();
        $service_rate_price=$service->basePrice;
        $category=Category::where('clothType','like','%'.$clothList->category.'%')->where('service_rate_id','like','%'.$service->id.'%')->first();
        $category_addOn_price=$category->addOnPrice;
        $order->total=$order->total-(($service_rate_price+$category_addOn_price)*$clothList->quantity);
        $order->save();
        $id=$clothList->id;
        if($clothList->delete()){
            return response()->json([
                'success'=>'true',
                'message'=>'cloth list id : ' . $id . 'delete success'
            ],Response::HTTP_OK);
        }
        return response()->json([
            'success'=> 'false',
            'message'=>'cloth list id : ' . $id . 'delete failed'
        ],Response::HTTP_BAD_REQUEST);

    }

    public function editClothList(Request $request,Order $order,ClothList $clothList){
        $service=ServiceRate::where('service','like','%'.$clothList->service.'%')->first();
        $service_rate_price=$service->basePrice;
        $category=Category::where('clothType','like','%'.$clothList->category.'%')->where('service_rate_id','like','%'.$service->id.'%')->first();
        $category_addOn_price=$category->addOnPrice;
        $qty=$clothList->quantity;
        $order->total=$order->total-(($service_rate_price+$category_addOn_price)*$qty);
        $order->save();

        if($request->has('category')) $clothList->category=$request->get('category');
        if($request->has('quantity')) $clothList->quantity=$request->get('quantity');
        if($request->has('service')) $clothList->service=$request->get('service');

        if($request->has('service')) $service=ServiceRate::where('service','like','%'.$request->get('service').'%')->first();
        $service_rate_price=$service->basePrice;
        if($request->has('category')) $category=Category::where('clothType','like','%'.$request->get('category').'%')->where('service_rate_id','like','%'.$service->id.'%')->first();
        $category_addOn_price=$category->addOnPrice;
        if($request->has('quantity')) $qty=$request->get('quantity');
        $order->total=$order->total+(($service_rate_price+$category_addOn_price)*$qty);

        if($clothList->save()){
            $order->clothLists()->save($clothList);
            $order->save();

            return response()->json([
                'success' => true,
                'message' => 'Cloth List updated with id ' . $clothList->id,
                'cloth_list_id' =>$clothList->id
            ],Response::HTTP_OK);
        }
        return response()->json([

            'success' => false,
            'message' => 'Cloth List updated failed'
        ], Response::HTTP_BAD_REQUEST);


    }

    // public function makeInvoice(Request $request, Order $order){
    //     $inv=new Invoice_receipt();
    //     $inv->EMP_name=$order->respond_EMP;
    //     $inv->CS_id=$order->customers->id;
    //     $inv->CS_name=$order->customers->name;
    //     $inv->CS_ADS=$order->deli_ADS;
    //     $inv->pick_date=$order->pick_date;
    //     $inv->pick_time=$order->pick_time;
    //     $inv->deli_date=$order->deli_date;
    //     $inv->deli_time=$order->deli_time;
    //     $inv->is_membership_or=$order->is_membership_or;
    //     $inv->pick_ser_charge=$order->pick_ser_charge;
    //     $inv->deli_ser_charge=$order->deli_ser_charge;
    //     $inv->deli_EMP=$order->deli_EMP;
    //     $inv->total=$order->total;
    //     $inv->pay_method=$order->pay_method;

    //     if ($inv->save()) {
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Invoice Receipt created with id ' . $inv->id,
    //             'order_id' =>$inv->id
    //         ],Response::HTTP_OK);
    //     }
    //     return response()->json([
    //         'success' => false,
    //         'message' => 'Invoice Receipt create failed'
    //     ], Response::HTTP_BAD_REQUEST);

    // }

    public function storeWithPhone(Request $request)
    {
        $userPhone=Auth::user()->phone;

        $order=new Order();

        $order->name="ORA"."-".(string)random_int(10000,99999);
        $order->service=$request->get('service');
        $order->pick_date=$request->get('pick_date') ?? null;
        $order->pick_time=$request->get('pick_time') ?? null;
        $order->deli_date=$request->get('deli_date') ?? null;
        $order->deli_time=$request->get('deli_time') ?? null;
        $order->address=$request->get('address');
        $order->responder=$request->get('responder');
        $order->deliver=$request->get('deliver') ?? null;
        $order->pay_status=$request->get('pay_status');
        $order->pay_method=$request->get('pay_method');
        $order->pick_ser_charge=$request->get('pick_ser_charge') ?? null;
        $order->deli_ser_charge=$request->get('deli_ser_charge') ?? null;
        $order->is_membership_or=$request->get('is_membership_or');
        $order->employee_id=$request->get('employee_id');
        $order->cus_phone=$userPhone;


        if ($order->save()) {

            $customer=Customer::where('phone','like','%'.$userPhone.'%')->first();
            $order->customers()->attach($customer->id);

            return response()->json([
                'success' => true,
                'message' => 'Order created with id ' . $order->id,
                'order_id' =>$order->id
            ],Response::HTTP_CREATED);


        }
        return response()->json([
            'success' => false,
            'message' => 'Order create failed'
        ], Response::HTTP_BAD_REQUEST);

    }

    public function generateQr(Order $order){
        // $pp = new \KS\PromptPay();
        $owner=Employee::where('role','like','OWNER')->first();

        // //Generate PromptPay Payload
        // $target = $owner->phone;
        // echo $pp->generatePayload($target);
        // //00020101021129370016A000000677010111011300668999999995802TH53037646304FE29

        //Generate PromptPay Payload With Amount
        // $target = $owner->phone;
        // $amount = $order->total;
        //  echo $pp->generatePayload($target, $amount);
        // $qr=$pp->generatePayload($target, $amount);
        //00020101021229370016A000000677010111011300668999999995802TH53037645406420.006304CF9E

        // //Generate QR Code PNG file
        // $target = '1-2345-67890-12-3';
        // $savePath = '/tmp/qrcode.png';
        // $pp->generateQrCode($savePath, $target);

        // //Generate QR Code With Amount
        // $amount = $order->total;
        // $pp->generateQrCode($savePath, $target, $amount);

        // // //Set QR Code Size Pixel
        // $width = 1000;
        // $pp->generateQrCode($savePath, $target, $amount, $width);

        // return ;
        return response()->json([
            'phone'=>$owner->phone,
            'total'=>$order->total
        ]);
    }

    public function changeStatusInProgress(){
        
    }






}
