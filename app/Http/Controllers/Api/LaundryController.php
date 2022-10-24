<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Laundry;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LaundryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api',['except'=>['store']]);
    }
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

        $user=new User();
        $user->name=$request->get('ownerName');
        $user->phone=$request->get('ownerPhone');
        $user->email=$request->get('ownerEmail');
        $user->realrole="OWNER";
        $user->password=bcrypt($request->get('password'));
        $user->save();

        $employee=new Employee();
        $employee->name=$request->get('ownerName');
        $employee->phone=$request->get('ownerPhone');
        $employee->email=$request->get('ownerEmail');
        $employee->address=$request->get('ownerAddress');
        $employee->role="OWNER";
        $employee->password=bcrypt($request->get('password'));
        $employee->ID_Card=$request->get("ownerIdCard");
        $employee->bank_account_number=$request->get("ownerBankNum");
        $employee->bank_name=$request->get("ownerBankName");
        $employee->save() ;


        $user=User::where('phone','like','%'.$request->get('ownerPhone').'%')->first();

        $laundry->name=$request->get('shopName');
        $laundry->phone=$request->get('shopPhone');
        $laundry->address=$request->get('shopAddress');
        $laundry->lineId=$request->get('lineId');
        $laundry->workDay=$request->get('workDay');
        $laundry->owner=$user->id ;
        $laundry->email=$request->get('shopEmail');
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

    public function openLaundry(Laundry $laundry){
        $laundry->status="open";
        if($laundry->save()){

            return response()->json([
                'success'=>true,
                'message'=> $laundry->status
            ],Response::HTTP_OK);
        }

        return response()->json([
            'success'=>false,
            'message'=>'open laundry failed'
        ]);
    }

    public function closeLaundry(Laundry $laundry){
        $laundry->status="close";
        if($laundry->save()){

            return response()->json([
                'success'=>true,
                'message'=> $laundry->status
            ],Response::HTTP_OK);
        }

        return response()->json([
            'success'=>false,
            'message'=>'close laundry failed'
        ]);
    }

    public function getStatus(Laundry $laundry){
        return response()->json([
            'status'=>$laundry->status
        ]);
    }

    public function getName(Laundry $laundry){
        return response()->json([
            'name'=>$laundry->name
        ]);
    }
}
