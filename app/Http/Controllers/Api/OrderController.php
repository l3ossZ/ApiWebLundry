<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ClothList;
use App\Models\Customer;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController extends Controller
{
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
        $order->pick_date=$request->get('pick_date') ?? null;
        $order->pick_time=$request->get('pick_time') ?? null;
        $order->deli_date=$request->get('deli_date') ?? null;
        $order->deli_time=$request->get('deli_time') ?? null;
        $order->pick_ADS=$request->get('pick_ADS');
        $order->deli_ADS=$request->get('deli_ADS');
        $order->respond_EMP=$request->get('respond_EMP');
        $order->deli_EMP=$request->get('deli_EMP') ?? null;
        $order->pay_status=$request->get('pay_status');
        $order->pay_method=$request->get('pay_method');
        $order->pick_ser_charge=$request->get('pick_ser_charge') ?? null;
        $order->deli_ser_charge=$request->get('deli_ser_charge') ?? null;
        $order->total=$request->get('total');
        $order->status=$request->get('status');
        $order->is_membership_or=$request->get('is_membership_or');
        $order->employee_id=$request->get('employee_id');
        $order->cus_phone=$request->get('cus_phone');





        if ($order->save()) {

            $customer=Customer::where('phone','like','%'.$request->get('cus_phone').'%')->first();
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
        //
        $customer=$order->customers;
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
        if($request->has('pick_date')) $order->pick_date=$request->get('pick_date');
        if($request->has('pick_time')) $order->pick_time=$request->get('pick_time');
        if($request->has('deli_date')) $order->deli_date=$request->get('deli_date');
        if($request->has('deli_time')) $order->deli_time=$request->get('deli_time');
        if($request->has('pick_ADS')) $order->pick_ADS=$request->get('pick_ADS');
        if($request->has('deli_ADS')) $order->deli_ADS=$request->get('deli_ADS');
        if($request->has('respond_EMP')) $order->respond_EMP=$request->get('respond_EMP');
        if($request->has('deli_EMP')) $order->deli_EMP=$request->get('deli_EMP');
        if($request->has('pay_status')) $order->pay_status=$request->get('pay_status');
        if($request->has('pay_method')) $order->pay_method=$request->get('pay_method');
        if($request->has('pick_ser_charge')) $order->pick_ser_charge=$request->get('pick_ser_charge');
        if($request->has('deli_ser_charge')) $order->deli_ser_charge=$request->get('deli_ser_charge') ;
        if($request->has('total')) $order->total=$request->get('total');
        if($request->has('status')) $order->status=$request->get('status');
        if($request->has('is_membership_or')) $order->is_membership_or=$request->get('is_membership_or');
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

    public function storeClothList(Request $request,Order $order){

    }


}