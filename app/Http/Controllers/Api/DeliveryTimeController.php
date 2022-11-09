<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DeliveryTime;
use App\Models\Laundry;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;



class DeliveryTimeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['getAvailableInDateTime']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deliveryTime=DeliveryTime::get();
        return $deliveryTime;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $today=Carbon::now()->toDateString();

        $deliveryTime=new DeliveryTime();
        $deliveryTime->date=$request->get('date');
        $deliveryTime->time=$request->get('time');
        $deliveryTime->orderName=$request->get('orderName');
        $deliveryTime->job=$request->get('job');
        $deliveryTime->deliver=$request->get('deliver')??"ยังไม่ลงทะเบียน" ;

        $order = Order::where('name',$deliveryTime->orderName)->first();
        if($deliveryTime->job=="ส่งผ้า"){
            $order->deli_date=$deliveryTime->date;
            $order->deli_time=$deliveryTime->time;
        }
        else if ($deliveryTime->job == "รับผ้า"){
            $order->pick_date=$deliveryTime->date;
            $order->pick_time=$deliveryTime->time;
        }
        $order->save();

        if ($deliveryTime->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Delivery Time created with id ' . $deliveryTime->id

            ],Response::HTTP_OK);
        }
        return response()->json([
            'success' => false,
            'message' => 'Delivery Time update failed'
        ], Response::HTTP_BAD_REQUEST);
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DeliveryTime  $deliveryTime
     * @return \Illuminate\Http\Response
     */
    public function show(DeliveryTime $deliveryTime)
    {
        //
        return $deliveryTime;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DeliveryTime  $deliveryTime
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DeliveryTime $deliveryTime)
    {
        //

        $deliveryTime->date=$request->get('date');
        $deliveryTime->time=$request->get('time');
        $deliveryTime->orderName=$request->get('orderName');
        $deliveryTime->job=$request->get('job');
        $deliveryTime->deliver=$request->get('deliver');
        if ($deliveryTime->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Delivery Time updated with id ' . $deliveryTime->id

            ],Response::HTTP_OK);
        }
        return response()->json([
            'success' => false,
            'message' => 'Delivery Time update failed'
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DeliveryTime  $deliveryTime
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeliveryTime $deliveryTime)
    {
        if($deliveryTime->delete()){
            return response()->json([
                'success' => true,
                'message' => "Employee  has been deleted"
            ], Response::HTTP_OK);
        }
        return response()->json([
            'success' => false,
            'message' => "Employee  delete failed"
        ], Response::HTTP_BAD_REQUEST);
    }

    public function getNumOfWork(Request $request){
        $deliveryTime = DeliveryTime::where('time',$request->get("deli_time"))
            ->whereDate('date','=',date($request->get('deli_date')));
        $n = $deliveryTime->count();
        return response()->json([
            'numOfWork' => $n
        ],Response::HTTP_OK);
    }

    public function getAvailableInDateTime(Request $request){
        $id = 1 ;
        $morn = "ช่วงเช้า";
        $after= "ช่วงบ่าย";
        $even = "ช่วงเย็น" ;
        $laundry = Laundry::where('id',$id)->first()->pluck('numOfWork');

        $morn = DeliveryTime::where('time',$morn)
            ->whereDate('date','=',date($request->get('deli_date')))->count();
        if($morn < $laundry[0]){
            $morn = true ;
        }
        else{
            $morn = false;
        }

        $after = DeliveryTime::where('time',$after)
            ->whereDate('date','=',date($request->get('deli_date')))->count();
        if($after < $laundry[0]){
            $after = true ;
        }
        else{
            $after = false;
        }
        $even = DeliveryTime::where('time',$even)
            ->whereDate('date','=',date($request->get('deli_date')))->count();
        if($even < $laundry[0]){
            $even = true ;
        }
        else{
            $even = false;
        }
        return response()->json([
            'date' => $request->get('deli_date'),
            'maxWorkPerTime' => $laundry[0],
            'morning' => $morn,
            'after' => $after,
            'even'=> $even
        ],Response::HTTP_OK);
    }

    public function addDeliver(DeliveryTime $deliveryTime,Request $request){
        $deliveryTime->deliver=$request->get('deliver');
        $deliveryTime->save();
        
        $order = Order::where('name',$request->get("orderName"))->first();
        $order->deliver=$deliveryTime->deliver;
        $order->save();
        return response()->json([
            'success'=>true,
            'message'=>'add Deliver Complete '.$deliveryTime->id
        ]);
    }

//    public function editDeliverTime(DeliveryTime $deliveryTime, Request $request){
//        $cancel = "cancel";
//        $deliveryTime->job=$cancel;
//        if($deliveryTime->save()){
//            $deliveryTime=new DeliveryTime();
//            $deliveryTime->date=$request->get('date');
//            $deliveryTime->time=$request->get('time');
//            $deliveryTime->orderName=$request->get('orderName');
//            $deliveryTime->job=$request->get('job');
//            $deliver = "ยังไม่ลงทะเบียน" ;
//            $deliveryTime->deliver=$deliver;
//            if ($deliveryTime->save()) {
//                return response()->json([
//                    'success' => true,
//                    'message' => 'Delivery Time updated with id ' . $deliveryTime->id
//                ],Response::HTTP_OK);
//            }
//            return response()->json([
//                'success' => false,
//                'message' => 'Delivery Time update failed'
//            ], Response::HTTP_BAD_REQUEST);
//        }
//        else{
//            return response()->json([
//                'success' => false,
//                'message' => 'Delivery Time update failed'
//            ], Response::HTTP_BAD_REQUEST);
//        }

//    }
    public function cancelDelivery(DeliveryTime $deliveryTime){
        $cancel = "cancel";
        $deliveryTime->job = $cancel;
        if ($deliveryTime->save()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Delivery Time Cancel with id ' . $deliveryTime->id
                ],Response::HTTP_OK);
            }
            return response()->json([
                'success' => false,
                'message' => 'Delivery Time Cancel failed'
            ], Response::HTTP_BAD_REQUEST);
    }
}
