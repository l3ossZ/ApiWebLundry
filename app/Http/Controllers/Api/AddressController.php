<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
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
        $userPhone=Auth::user()->phone;
        $address=new Address();
        $address->name=$request->get('name');
        $address->u_code=$request->get('u_code');
        $address->cus_phone=$request->get('cus_phone')??$userPhone;
        $address->lat=$request->has('lat') ? $request->get('lat') : null;
        $address->lng=$request->has('lng') ?  $request->get('lng') : null;
        $address->hint=$request->has('hint') ?  $request->get('hint') : null;
        $address->contact=$request->has('contact') ? $request->get('contact') : null;

        if ($address->save()) {
            $customer=Customer::where('phone','like','%'.$userPhone.'%')->first();
            $address->customers()->attach($customer->id);
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
        $customers=$address->customers;

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
        if($request->has('lat')) $address->lat=$request->get('lat');
        if($request->has('lng')) $address->lng=$request->get('lng');
        if($request->has('hint')) $address->hint=$request->get('hint');
        if($request->has('contact')) $address->contact=$request->get('contact');

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
