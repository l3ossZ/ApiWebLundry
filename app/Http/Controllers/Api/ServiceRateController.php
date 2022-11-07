<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ServiceRate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;



class ServiceRateController extends Controller
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
        $serviceRate=ServiceRate::get();
        return $serviceRate;
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $serviceRate=new ServiceRate();
        $serviceRate->service=$request->get('service');
        $serviceRate->basePrice=$request->get('basePrice');
        if ($serviceRate->save()) {
            return response()->json([
                'success' => true,
                'message' => 'ServiceRate created with id ' . $serviceRate->id,
                'serviceRate_id' =>$serviceRate->id
            ],Response::HTTP_CREATED);
        }
        return response()->json([
            'success' => false,
            'message' => 'ServiceRate creation failed'
        ], Response::HTTP_BAD_REQUEST);
        //
    }


    public function show(ServiceRate $serviceRate)
    {
        //
        $category=$serviceRate->category;
        return $serviceRate;
    }


    public function update(Request $request, ServiceRate $serviceRate)
    {
        //
        if($request->has('service')) $serviceRate->service=$request->get('service');
        if($request->has('basePrice')) $serviceRate->basePrice=$request->get('basePrice');

        if ($serviceRate->save()) {
            return response()->json([
                'success' => true,
                'message' => 'ServiceRate updated with id ' . $serviceRate->id,
                'employee_id' =>$serviceRate->id
            ],Response::HTTP_OK);
        }
        return response()->json([
            'success' => false,
            'message' => 'ServiceRate update failed'
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ServiceRate  $serviceRate
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceRate $serviceRate)
    {
        if($serviceRate->delete()){
            return response()->json([
                'success'=>true,
                'message'=>'delete complete'
            ]);
        }
    }


}
