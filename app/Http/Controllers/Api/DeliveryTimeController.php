<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DeliveryTime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DeliveryTimeController extends Controller
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
        $deliveryTime->date=$request->get('date')??$today;
        $deliveryTime->time=$request->get('time');
        $deliveryTime->orderName=$request->get('orderName')??"";
        $deliveryTime->job=$request->get('job');
        $deliveryTime->numOfWork=$request->get('numOfWork') ?? 3 ;

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
        //
    }
}
