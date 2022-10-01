<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()

    {
        $customer=Customer::get();
        return $customer;
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
        //
        $customer=new Customer();
        $customer->name=$request->get('name');
        $customer->phone=$request->get('phone');
        $customer->email=$request->get('email');
        $customer->pwd=$request->get('pwd');
        $customer->isMembership=$request->get('isMembership')??false;
        $customer->memService=$request->get('memService')??null;
        $customer->memCredit=$request->get('memCredit')??null;

        if ($customer->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Customer created with id ' . $customer->id,
                'customer_id' =>$customer->id
            ],Response::HTTP_CREATED);
        }
        return response()->json([
            'success' => false,
            'message' => 'Customer creation failed'
        ], Response::HTTP_BAD_REQUEST);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        return $customer;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        //
        if($request->has('name')) $customer->name=$request->get('name');
        if($request->has('phone')) $customer->phone=$request->get('phone');
        if($request->has('email')) $customer->email=$request->get('email');
        if($request->has('pwd')) $customer->pwd=$request->get('password');
        if($request->has('isMembership')) $customer->isMembership=$request->get('isMembership');
        if($request->has('memService')) $customer->memService=$request->get('memService');
        if($request->has('memCredit')) $customer->memCredit=$request->get('memCredit');

        if ($customer->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Customer updated with id ' . $customer->id,
                'customer_id' =>$customer->id
            ],Response::HTTP_OK);
        }
        return response()->json([
            'success' => false,
            'message' => 'Customer update failed'
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {

    }

    public function search(Request $request) {
        $q = $request->query('q');
        $sort = $request->query('sort') ?? 'asc';
        $customers = Customer::where('phone', 'LIKE', "%{$q}%")
                         ->orderBy('phone', $sort)
                         ->get();
        return $customers;
    }
}