<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $address=Address::get();
        return $address;
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
        $address=new Address();
        $address->name=$request->get('name');
        $address->u_code=$request->get('u_code');
        $address->lat=$request->has('lat') ? $request->get('lat') : null;
        $address->lng=$request->has('lng') ?  $request->get('lng') : null;
        $address->hint=$request->has('hint') ?  $request->get('hint') : null;

        if ($address->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Address created with id ' . $address->id,
                'address_id' =>$address->id
            ],Response::HTTP_CREATED);
        }
        return response()->json([
            'success' => false,
            'message' => 'address creation failed'
        ], Response::HTTP_BAD_REQUEST);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function show(Address $address)
    {
        //
        return $address;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Address $address)
    {
        if($request->has('name')) $address->name=$request->get('name');
        if($request->has('u_code')) $address->u_code=$request->get('u_code');
        if($request->has('lat')) $address->lat=$request->get('lat')??null;
        if($request->has('lng')) $address->lng=$request->get('lng')??null;
        if($request->has('hint')) $address->hint=$request->get('hint')??null;

        if ($address->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Address updated with id ' . $address->id,
                'address_id' =>$address->id
            ],Response::HTTP_OK);
        }
        return response()->json([
            'success' => false,
            'message' => 'address update failed'
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $address)
    {
        //
        $name=$address->name;
        if($address->delete()){
            return response()->json([
                'success' => true,
                'message' => "Address {$name} has been deleted"
            ], Response::HTTP_OK);
        }
        return response()->json([
            'success' => false,
            'message' => "Address {$name} delete failed"
        ], Response::HTTP_BAD_REQUEST);
    }
}
