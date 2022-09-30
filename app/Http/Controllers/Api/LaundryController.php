<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Laundry;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LaundryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $laundry=Laundry::get();
        return $laundry;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $laundry=new Laundry();

        $laundry->name=$request->get('name');
        $laundry->phone=$request->get('phone');
        $laundry->owner=$request->get('owner');
        $laundry->email=$request->get('email');
        $laundry->address=$request->get('address');
        $laundry->lineId=$request->get('lineId');
        $laundry->opentime=$request->get('opentime');
        $laundry->closetime=$request->get('closetime');

        if ($laundry->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Laundry created with id ' . $laundry->id,
                'laundry_id' =>$laundry->id
            ],Response::HTTP_CREATED);
        }
        return response()->json([
            'success' => false,
            'message' => 'Laundry creation failed'
        ], Response::HTTP_BAD_REQUEST);



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Laundry  $laundry
     * @return \Illuminate\Http\Response
     */
    public function show(Laundry $laundry)
    {
        //
        return $laundry;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Laundry  $laundry
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Laundry $laundry)
    {
        if($request->has('name')) $laundry->name=$request->get('name');
        if($request->has('phone')) $laundry->phone=$request->get('phone');
        if($request->has('owner')) $laundry->owner=$request->get('owner');
        if($request->has('email')) $laundry->email=$request->get('email');
        if($request->has('address')) $laundry->address=$request->get('address');
        if($request->has('lineId')) $laundry->lineId=$request->get('lineId');
        if($request->has('opentime')) $laundry->opentime=$request->get('opentime');
        if($request->has('closetime')) $laundry->closetime=$request->get('closetime');

        if ($laundry->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Laundry updated with id ' . $laundry->id,
                'laundry_id' =>$laundry->id
            ],Response::HTTP_OK);
        }
        return response()->json([
            'success' => false,
            'message' => 'Laundry update failed'
        ], Response::HTTP_BAD_REQUEST);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Laundry  $laundry
     * @return \Illuminate\Http\Response
     */
    public function destroy(Laundry $laundry)
    {
        //
    }
}
