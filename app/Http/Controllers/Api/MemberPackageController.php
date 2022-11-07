<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MemberPackage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;



class MemberPackageController extends Controller
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
        $member_package=MemberPackage::get();
        return $member_package;

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $member_package=new MemberPackage();
        $member_package->service=$request->get('service');
        $member_package->quantity=$request->get('quantity');
        $member_package->price=$request->get('price');

        if ($member_package->save()) {
            return response()->json([
                'success' => true,
                'message' => 'MemberPackage created with id ' . $member_package->id,
                'member_package' =>$member_package->id
            ],Response::HTTP_CREATED);
        }
        return response()->json([
            'success' => false,
            'message' => 'MemberPackage creation failed'
        ], Response::HTTP_BAD_REQUEST);


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MemberPackage  $memberPackage
     * @return \Illuminate\Http\Response
     */
    public function show(MemberPackage $memberPackage)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MemberPackage  $memberPackage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MemberPackage $memberPackage)
    {
        $memberPackage->service=$request->get('service');
        $memberPackage->quantity=$request->get('quantity');
        $memberPackage->price=$request->get('price');

        if ($memberPackage->save()) {
            return response()->json([
                'success' => true,
                'message' => 'MemberPackage created with id ' . $memberPackage->id,
                'member_package' =>$memberPackage->id
            ],Response::HTTP_CREATED);
        }
        return response()->json([
            'success' => false,
            'message' => 'MemberPackage creation failed'
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MemberPackage  $memberPackage
     * @return \Illuminate\Http\Response
     */
    public function destroy(MemberPackage $memberPackage)
    {
        $id=$memberPackage->id;
        if($memberPackage->delete()){
            return response()->json([
                'success' => true,
                'message' => "MemberPackage id: {$id} has been deleted"
            ], Response::HTTP_OK);
        }
        return response()->json([
            'success' => false,
            'message' => "MemberPackage id : {$id} delete failed"
        ], Response::HTTP_BAD_REQUEST);
    }

}
