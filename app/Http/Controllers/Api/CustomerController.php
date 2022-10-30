<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use App\Models\Address;
use App\Models\Customer;
use App\Models\Order;
use App\Models\ServiceRate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Claims\Custom;

class CustomerController extends Controller
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


        $customer=Customer::get();
        return CustomerResource::collection($customer);
        // return $customer;
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
        $customer->email=$request->get('email')??null;
        $customer->pwd=$request->get('pwd');
        $customer->isMembership=$request->get('isMembership')??false;
        $customer->memService=$request->get('memService')??"-";
        $customer->memCredit=$request->get('memCredit')??0;
        $user=new User();
        $user->name=$request->get('name');
        $user->phone=$request->get('phone');
        $user->email=$request->get('email');
        // $user->role=$request->get('role');
        $user->realrole="customer";
        $user->password=bcrypt($request->get('pwd'));
        $user->save();

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

        // $address=$customer->address;
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
        $user=User::where('name','like','%'.$customer->name.'%')->first();

        if($request->has('name')) $customer->name=$request->get('name');
        if($request->has('phone')) $customer->phone=$request->get('phone');
        if($request->has('email')) $customer->email=$request->get('email');
        if($request->has('pwd')) $customer->pwd=$request->get('pwd');
        if($request->has('isMembership')) $customer->isMembership=$request->get('isMembership');
        if($request->has('memService')) $customer->memService=$request->get('memService');
        if($request->has('memCredit')) $customer->memCredit=$request->get('memCredit');
        if($request->has('name')) $user->name=$request->get('name');
        if($request->has('phone')) $user->phone=$request->get('phone');
        if($request->has('email')) $user->email=$request->get('email');
        $user->realrole="customer";
        if($request->has('pwd')) $user->password=bcrypt($request->get('pwd'));
        $user->save();



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

    public function searchEmail(Request $request) {
        $q = $request->query('q');
        $sort = $request->query('sort') ?? 'asc';
        $customers = Customer::where('email', 'LIKE', "%{$q}%")
                         ->orderBy('email', $sort)
                         ->get();
        return $customers;
    }

    public function getOrderOfCustomer(Customer $customer){
        $order=Order::where('cus_phone','like','%'.$customer->phone.'%')->get();
        return $order;
    }

    public function getOrderOfCustomerAuth(){
        $phone=Auth::user()->phone;
        $order=Order::where('cus_phone','like','%'.$phone.'%')->get();
        return $order;
    }

    public function getCustomerAddress(Customer $customer){
        $address=Address::where('cus_phone','like','%'.$customer->phone.'%')->get();
        return $address;
    }

    public function getCustomerAddressAuth(){
        $phone=Auth::user()->phone;
        $address=Address::where('cus_phone','like','%'.$phone.'%')->get();
        return $address;
    }

    public function addMemberService(Customer $customer,Request $request){
        $customer->isMembership=true;
        $customer->memService=$request->get('memService');
        $customer->memCredit=$request->get('memCredit');
        $customer->save();

        return response()->json([
            'success'=>true,
            'message'=>'add Member Service Complete '.$customer->id
        ]);
    }

//    public function getNumOfCustomer(){
//        $customer=Customer::all();
//        $n = $customer->count();
//        return response()->json([
//            'numOfCus' => $n
//        ],Response::HTTP_OK);
//    }
//    public function getNumOfMember(){
//        $customer=Customer::where('isMembership',1);
//        $n = $customer->count();
//        return response()->json([
//            'numOfMem' => $n
//        ],Response::HTTP_OK);
//    }
}
