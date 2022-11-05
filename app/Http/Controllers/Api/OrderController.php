<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ClothList;
use App\Models\Customer;
use App\Models\DeliveryTime;
use App\Models\Employee;
use App\Models\Invoice_receipt;
use App\Models\Order;
use App\Models\ServiceRate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use function Symfony\Component\String\s;

class OrderController extends Controller
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
        $orders=Order::get();
        return $orders;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $order=new Order();

        $order->service=$request->get('service');
        $order->name="ORS"."-".(string)random_int(10000,99999);
        $order->pick_date=$request->get('pick_date') ?? null;
        $order->pick_time=$request->get('pick_time') ?? null;
        $order->deli_date=$request->get('deli_date') ?? null;
        $order->deli_time=$request->get('deli_time') ?? null;
        $order->address=$request->get('address') ?? null;
        $order->status="order in";
        $order->responder=$request->get('responder');
        $notRegis = "ยังไม่ลงทะเบียน" ;
        $order->deliver=$notRegis;
        if($order->address == null){
            $order->deliver = null ;
        }
        $order->pay_method=$request->get('pay_method') ?? "เงินสด";
        $order->pick_ser_charge=$request->get('pick_ser_charge') ?? 0;
        $order->deli_ser_charge=$request->get('deli_ser_charge') ?? 0;
        $order->is_membership_or=$request->get('is_membership_or') ?? false;
        $order->cus_phone=$request->get('cus_phone');
        $employee=Employee::where('name','like','%'.$request->get('responder').'%')->first();
        $order->employee_id=$employee->id;


        if ($order->save()) {
            $customer=Customer::where('phone','like','%'.$request->get('cus_phone').'%')->first();
            // $new_order=Order::where('cus_phone','like','%'.$request->get('cus_phone').'%')->first();
            // $customer->orders()->attach($new_order->id);
            $order->customers()->attach($customer->id);
            $this->calDeliOnSite($order);

            return response()->json([
                'success' => true,
                'message' => 'Order created with id ' . $order->id,
                'order_id' =>$order->id
            ],Response::HTTP_CREATED);


        }
        return response()->json([
            'success' => false,
            'message' => 'Order create failed'
        ], Response::HTTP_BAD_REQUEST);




    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $clothList=$order->clothLists;
        return $order;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {


        if($request->has('service')) $order->service=$request->get('service');
        if($request->has('pick_date')) $order->pick_date=$request->get('pick_date') ?? null;
        if($request->has('pick_time')) $order->pick_time=$request->get('pick_time') ?? null;
        if($request->has('deli_date')) $order->deli_date=$request->get('deli_date') ?? null;
        if($request->has('deli_time')) $order->deli_time=$request->get('deli_time') ?? null;
        if($request->has('address')) $order->address=$request->get('address');
        if($request->has('responder')) $order->responder=$request->get('responder');
        if($request->has('deliver')) $order->deliver=$request->get('deliver') ?? null;
        if($request->has('pay_status')) $order->pay_status=$request->get('pay_status');
        if($request->has('pay_method')) $order->pay_method=$request->get('pay_method');
        if($request->has('pick_ser_charge')) $order->pick_ser_charge=$request->get('pick_ser_charge') ?? null;
        if($request->has('deli_ser_charge')) $order->deli_ser_charge=$request->get('deli_ser_charge') ?? null;
        if($request->has('status')) $order->status=$request->get('status');
        if($request->has('is_membership_or')) $order->is_membership_or=$request->get('is_membership_or');
        if($request->has('employee_id')) $order->employee_id=$request->get('employee_id');
        if($request->has('cus_phone')) $order->cus_phone=$request->get('cus_phone');
        //

        if ($order->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Order updated with id ' . $order->id,
                'order_id' =>$order->id
            ],Response::HTTP_OK);
        }
        return response()->json([
            'success' => false,
            'message' => 'Order update failed'
        ], Response::HTTP_BAD_REQUEST);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }

    public function cancelOrder(Order $order){
        $cancel = "cancel";
        $order->status =  $cancel;
        if($order->save()){
            return response()->json([
                'success' => true,
                'message' => 'Cancel Order id ' . $order->id,
            ],Response::HTTP_CREATED);
        }
        return response()->json([

            'success' => false,
            'message' => 'Cancel Order failed'
        ], Response::HTTP_BAD_REQUEST);
    }

    public function storeClothList(Request $request, Order $order){
        $clothList=new ClothList();
        $clothList->category=$request->get('category');
        $clothList->quantity=$request->get('quantity');
        $clothList->service=$request->get('service');
        $clothList->order_id=$order->id;
        $service=ServiceRate::where('service','like','%'.$request->get('service').'%')->first();
        $service_rate_price=$service->basePrice;
        $category=Category::where('clothType','like','%'.$request->get('category').'%')->where('service_rate_id','like','%'.$service->id.'%')->first();
        $category_addOn_price=$category->addOnPrice;
        if($order->is_membership_or == false){
            $order->total=$order->total+(($service_rate_price+$category_addOn_price)*$request->get('quantity'));
        }

        // $clothList->service_rate_id=$service_rate->id;
        if($clothList->save()){
            $order->clothLists()->save($clothList);
            $order->save();

            return response()->json([
                'success' => true,
                'message' => 'Cloth List created with id ' . $clothList->id,
                'cloth_list_id' =>$clothList->id
            ],Response::HTTP_CREATED);
        }
        return response()->json([

            'success' => false,
            'message' => 'Cloth List created failed'
        ], Response::HTTP_BAD_REQUEST);
    }

    public function deleteClothList(Order $order,ClothList $clothList){
        $service=ServiceRate::where('service','like','%'.$clothList->service.'%')->first();
        $service_rate_price=$service->basePrice;
        $category=Category::where('clothType','like','%'.$clothList->category.'%')->where('service_rate_id','like','%'.$service->id.'%')->first();
        $category_addOn_price=$category->addOnPrice;
        $order->total=$order->total-(($service_rate_price+$category_addOn_price)*$clothList->quantity);
        $order->save();
        $id=$clothList->id;
        if($clothList->delete()){
            return response()->json([
                'success'=>'true',
                'message'=>'cloth list id : ' . $id . 'delete success'
            ],Response::HTTP_OK);
        }
        return response()->json([
            'success'=> 'false',
            'message'=>'cloth list id : ' . $id . 'delete failed'
        ],Response::HTTP_BAD_REQUEST);

    }



    public function editClothList(Request $request,Order $order,ClothList $clothList){
        $service=ServiceRate::where('service','like','%'.$clothList->service.'%')->first();
        $service_rate_price=$service->basePrice;
        $category=Category::where('clothType','like','%'.$clothList->category.'%')->where('service_rate_id','like','%'.$service->id.'%')->first();
        $category_addOn_price=$category->addOnPrice;
        $qty=$clothList->quantity;
        $order->total=$order->total-(($service_rate_price+$category_addOn_price)*$qty);
        $order->save();

        if($request->has('category')) $clothList->category=$request->get('category');
        if($request->has('quantity')) $clothList->quantity=$request->get('quantity');
        if($request->has('service')) $clothList->service=$request->get('service');

        if($request->has('service')) $service=ServiceRate::where('service','like','%'.$request->get('service').'%')->first();
        $service_rate_price=$service->basePrice;
        if($request->has('category')) $category=Category::where('clothType','like','%'.$request->get('category').'%')->where('service_rate_id','like','%'.$service->id.'%')->first();
        $category_addOn_price=$category->addOnPrice;
        if($request->has('quantity')) $qty=$request->get('quantity');
        $order->total=$order->total+(($service_rate_price+$category_addOn_price)*$qty);

        if($clothList->save()){
            $order->clothLists()->save($clothList);
            $order->save();

            return response()->json([
                'success' => true,
                'message' => 'Cloth List updated with id ' . $clothList->id,
                'cloth_list_id' =>$clothList->id
            ],Response::HTTP_OK);
        }
        return response()->json([

            'success' => false,
            'message' => 'Cloth List updated failed'
        ], Response::HTTP_BAD_REQUEST);


    }


    public function getOrderWeek(){
        $order = Order::whereDate('created_at',[Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();;
        return $order;
    }

    public function getOrderMonth(){
        $order = Order::whereMonth('created_at', Carbon::now()->month);
        return $order;
    }

    public function getOrderYear(){
        $order = Order::whereYear('created_at', Carbon::now()->year);
        return $order;
    }

    // public function makeInvoice(Request $request, Order $order){
    //     $inv=new Invoice_receipt();
    //     $inv->EMP_name=$order->respond_EMP;
    //     $inv->CS_id=$order->customers->id;
    //     $inv->CS_name=$order->customers->name;
    //     $inv->CS_ADS=$order->deli_ADS;
    //     $inv->pick_date=$order->pick_date;
    //     $inv->pick_time=$order->pick_time;
    //     $inv->deli_date=$order->deli_date;
    //     $inv->deli_time=$order->deli_time;
    //     $inv->is_membership_or=$order->is_membership_or;
    //     $inv->pick_ser_charge=$order->pick_ser_charge;
    //     $inv->deli_ser_charge=$order->deli_ser_charge;
    //     $inv->deli_EMP=$order->deli_EMP;
    //     $inv->total=$order->total;
    //     $inv->pay_method=$order->pay_method;

    //     if ($inv->save()) {
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Invoice Receipt created with id ' . $inv->id,
    //             'order_id' =>$inv->id
    //         ],Response::HTTP_OK);
    //     }
    //     return response()->json([
    //         'success' => false,
    //         'message' => 'Invoice Receipt create failed'
    //     ], Response::HTTP_BAD_REQUEST);

    // }

    public function storeWithPhone(Request $request)
    {
        $userPhone=Auth::user()->phone;

        $order=new Order();

        $order->name="ORA"."-".(string)random_int(10000,99999);
        $order->service=$request->get('service');
        $order->pick_date=$request->get('pick_date') ?? null;
        $order->pick_time=$request->get('pick_time') ?? null;
        $order->address=$request->get('address');
        $order->pay_method=$request->get('pay_method') ?? "เงินสด";
        $order->is_membership_or=$request->get('is_membership_or') ?? false;
        $employee=Employee::where('name','like','%'.$request->get('responder').'%')->first();
        $order->employee_id=$employee->id;
        $order->cus_phone=$userPhone;
        $notRegis = "ยังไม่ลงทะเบียน" ;
        $order->deliver=$notRegis;
        $order->responder=$notRegis;
        $order->deliver=$notRegis;


        if ($order->save()) {

            $customer=Customer::where('phone','like','%'.$userPhone.'%')->first();
            $order->customers()->attach($customer->id);

            return response()->json([
                'success' => true,
                'message' => 'Order created with id ' . $order->id,
                'order_id' =>$order->id
            ],Response::HTTP_CREATED);


        }
        return response()->json([
            'success' => false,
            'message' => 'Order create failed'
        ], Response::HTTP_BAD_REQUEST);

    }


    public function generateQr(Order $order){
        // $pp = new \KS\PromptPay();
        $owner=Employee::where('role','like','OWNER')->first();

        // //Generate PromptPay Payload
        // $target = $owner->phone;
        // echo $pp->generatePayload($target);
        // //00020101021129370016A000000677010111011300668999999995802TH53037646304FE29

        //Generate PromptPay Payload With Amount
        // $target = $owner->phone;
        // $amount = $order->total;
        //  echo $pp->generatePayload($target, $amount);
        // $qr=$pp->generatePayload($target, $amount);
        //00020101021229370016A000000677010111011300668999999995802TH53037645406420.006304CF9E

        // //Generate QR Code PNG file
        // $target = '1-2345-67890-12-3';
        // $savePath = '/tmp/qrcode.png';
        // $pp->generateQrCode($savePath, $target);

        // //Generate QR Code With Amount
        // $amount = $order->total;
        // $pp->generateQrCode($savePath, $target, $amount);

        // // //Set QR Code Size Pixel
        // $width = 1000;
        // $pp->generateQrCode($savePath, $target, $amount, $width);

        // return ;
        return response()->json([
            'phone'=>$owner->phone,
            'total'=>$order->total
        ]);
    }

    public function nextStatus(Order $order){
        if(str_contains($order->name,'ORS')){
            if($order->status=='order in'){
                $order->status="in progress";
                $order->save();
                return response()->json([
                    'success'=>true,
                    'message'=>'next status '.$order->status
                ]);
            }
            if($order->status=='in progress'){
                if($order->address!=null){
                    $order->status="finish laundry";
                    $order->save();
                    return response()->json([
                        'success'=>true,
                        'message'=>'next status '.$order->status
                    ]);
                }
            }

            if($order->status=='in progress'){
                if($order->address==null){
                    $order->status="ready for pick up";
                    $order->save();
                    return response()->json([
                        'success'=>true,
                        'message'=>'next status '.$order->status
                    ]);
                }
            }

            if($order->status=='finish laundry'){
                $order->status="go out delivery";
                $order->save();
                return response()->json([
                    'success'=>true,
                    'message'=>'next status '.$order->status
                ]);
            }

            if($order->status=='go out delivery'){
                $order->status="delivery complete";
                $order->save();
                return response()->json([
                    'success'=>true,
                    'message'=>'next status '.$order->status
                ]);
            }

            if($order->status=='delivery complete'){
                $order->status="complete";
                $order->save();
                return response()->json([
                    'success'=>true,
                    'message'=>'next status '.$order->status
                ]);
            }

            if($order->status=='ready for pick up'){
                $order->status="complete";
                $order->save();
                return response()->json([
                    'success'=>true,
                    'message'=>'next status '.$order->status
                ]);
            }
        }
        if(str_contains($order->name,'ORA')){
            if($order->status=='order add'){
                $order->status="order-confirm";
                $order->save();
                return response()->json([
                    'success'=>true,
                    'message'=>'next status '.$order->status
                ]);
            }

            if($order->status=='order-confirm'){
                $order->status="waiting for pick up";
                $order->save();
                return response()->json([
                    'success'=>true,
                    'message'=>'next status '.$order->status
                ]);
            }

            if($order->status=='waiting for pick up'){
                $order->status="pick up";
                $order->save();
                return response()->json([
                    'success'=>true,
                    'message'=>'next status '.$order->status
                ]);
            }

            if($order->status=='pick up'){
                $order->status="in progress";
                $order->save();
                return response()->json([
                    'success'=>true,
                    'message'=>'next status '.$order->status
                ]);
            }

            if($order->status=='in progress'){
                $order->status="finish laundry";
                $order->save();
                return response()->json([
                    'success'=>true,
                    'message'=>'next status '.$order->status
                ]);
            }

            if($order->status=='finish laundry'){
                $order->status="go out delivery";
                $order->save();
                return response()->json([
                    'success'=>true,
                    'message'=>'next status '.$order->status
                ]);
            }

            if($order->status=='go out delivery'){
                $order->status="delivery complete";
                $order->save();
                return response()->json([
                    'success'=>true,
                    'message'=>'next status '.$order->status
                ]);
            }

            if($order->status=='delivery complete'){
                $order->status="complete";
                $order->save();
                return response()->json([
                    'success'=>true,
                    'message'=>'next status '.$order->status
                ]);
            }
        }
    }

    public function calDeliOnSite(Order $order){
        if($order->address!=null && $order->is_membership_or != 1){
            $amount = 0;
            $clothLists=$order->clothLists->all();
            foreach($clothLists as $clothlist){
                $amount=$amount+$clothlist->quantity;
            }
            // Onsite With Deliver
            if($order->deli_date != null && $order->deli_time != null && $order->pick_date == null && $order->pick_time == null){
                $deliver = "ยังไม่ลงทะเบียน" ;
                $job = "ส่งผ้า" ;
                $delitime = new DeliveryTime();
                $delitime->date=$order->deli_date;
                $delitime->time=$order->deli_time;
                $delitime->orderName=$order->name;
                $delitime->deliver=$deliver;
                $order->deliver=$deliver;
                $delitime->job=$job;
                $delitime->save();
                if($amount<=15){
                    $order->deli_ser_charge=15;
                    $order->total=$order->total+15;
                    $order->save();
                }
                else if($amount>15 && $amount<=30){
                    $order->deli_ser_charge=25;
                    $order->total=$order->total+25;
                    $order->save();

                }
                else if($amount>30 && $amount<50){
                    $order->deli_ser_charge=30;
                    $order->total=$order->total+30;
                    $order->save();

                }
                else if($amount>50){
                    $order->deli_ser_charge=0;
                    $order->save();
                }
            }
        }
        // No Pick/Deli
        else{
            return;
        }
    }

    public function calDeliApp(Order $order){
        if($order->address!=null && $order->is_membership_or != 1){
            $amount = 0;
            $clothLists=$order->clothLists->all();
            foreach($clothLists as $clothlist){
                $amount=$amount+$clothlist->quantity;
            }
                if($amount<=15){
                    $order->deli_ser_charge=15;
                    $order->pick_ser_charge=15;
                    $order->total=$order->total+30;
                    $order->save();
                }
                else if($amount>15 && $amount<=30){
                    $order->deli_ser_charge=25;
                    $order->pick_ser_charge=25;
                    $order->total=$order->total+50;
                    $order->save();
                }
                else if($amount>30 && $amount<50){
                    $order->deli_ser_charge=30;
                    $order->pick_ser_charge=30;
                    $order->total=$order->total+60;
                    $order->save();
                }
                else if($amount>50){
                    $order->deli_ser_charge=0;
                    $order->pick_ser_charge=0;
                    $order->save();
                }
        }
        // No Pick/Deli
        else{
            return;
        }
    }

    public function payStatus(Order $order){
        $order->pay_status=true;
            $order->save();
            return response()->json([
                'success'=>true,
                'pick_ser_charge' => $order->pick_ser_charge,
                'deli_ser_charge' => $order->deli_ser_charge,
                'total'=> $order->total,
                'message'=>'pay complete '.$order->pay_status
            ]);
    }


//    public function payStatus(Order $order){
//        if($order->pay_method=="เงินสด"){
//            if($order->deliver!=null || $order->deli_date!=null || $order->deli_time!=null){
//                $amount=0;
//                $clothLists=$order->clothLists->all();
//                foreach($clothLists as $clothlist){
//                    $amount=$amount+$clothlist->quantity;
//                }
//                if($amount<=15){
//                    $order->deli_ser_charge=15;
//                    $order->total=$order->total+15;
//                    $order->save();
//                }
//                if($amount>15 && $amount<=40){
//                    $order->deli_ser_charge=25;
//                    $order->total=$order->total+25;
//                    $order->save();
//                }
//                if($amount>40){
//                    $order->deli_ser_charge=30;
//                    $order->total=$order->total+30;
//                    $order->save();
//                }
//                $order->pay_status=true;
//                $order->save();
//                return response()->json([
//                    'success'=>true,
//                    'message'=>'pay complete '.$order->pay_status
//                ]);
//            }
//
//            $order->pay_status=true;
//            $order->save();
//            return response()->json([
//                'success'=>true,
//                'message'=>'pay complete '.$order->pay_status
//            ]);
//        }
//        if($order->pay_method=="พร้อมเพย์"){
//            if($order->deliver!=null || $order->deli_date!=null || $order->deli_time!=null){
//                $amount=0;
//                $clothLists=$order->clothLists->all();
//                foreach($clothLists as $clothlist){
//                    $amount=$amount+$clothlist->quantity;
//                }
//                if($amount<=15){
//                    $order->deli_ser_charge=15;
//                    $order->total=$order->total+15;
//                    $order->save();
//                }
//                if($amount>15 && $amount<=40){
//                    $order->deli_ser_charge=25;
//                    $order->total=$order->total+25;
//                    $order->save();
//                }
//                if($amount>40){
//                    $order->deli_ser_charge=30;
//                    $order->total=$order->total+30;
//                    $order->save();
//                }
//                $order->pay_status=true;
//                $order->save();
//                return response()->json([
//                    'success'=>true,
//                    'message'=>'pay complete '.$order->pay_status
//                ]);
//            }
//
//            $order->pay_status=true;
//            $order->save();
//            return response()->json([
//                'success'=>true,
//                'message'=>'pay complete '.$order->pay_status
//            ]);
//        }
//        if($order->pay_method=="สมาชิก"){
//
//            $customer=Customer::where('phone','like','%'.$order->cus_phone.'%')->first();
//            if($customer->isMembership==true){
//                if($order->service=="ซักรีด" || $order->service=="ซักอบ"){
//                    $order->is_membership_or=true;
//                    $amount=0;
//                    $clothLists=$order->clothLists->all();
//                    foreach($clothLists as $clothlist){
//                        $amount=$amount+$clothlist->quantity;
//                    }
//                    $memCredit=$customer->memCredit;
//                    if($amount<$memCredit){
//                        $customer->memCredit=$memCredit-$amount;
//                        $order->pay_status=true;
//                        $order->save();
//                        $customer->save();
//
//                        return response()->json([
//                            'success'=>true,
//                            'message'=>'pay complete current credit :'.$customer->memCredit
//                        ]);
//                    }
//                }
//            }
//            return response()->json([
//                'success'=>false,
//                'message'=>'failed to pay'
//            ]);
//        }
//    }

//    public function storeDeliveryTime(Order $order,Request $request){
////        $order->deli_date=$request->get('deli_date');
////        $order->deli_time=$request->get('deli_time');
//        $job="ส่งผ้า";
//        if($request->get('deliver') != null){
//            $deliver=Employee::where('name','like','%'.$request->get('deliver').'%')->first();
//            $order->deliver=$deliver->name;
//            $deliveryTime=DeliveryTime::where('date','like','%'.$order->get('deli_date').'%')
//                ->where('time','like','%'.$order->get('deli_time').'%')
//                ->where('job','like','%'.$job.'%')->first();
//
//
//            if($deliveryTime->currentOrderWork<$deliveryTime->numOfWork){
//                if($deliveryTime->currentOrderWork==0){
//                    $deliveryTime->orderName=$order->name;
//                    $deliveryTime->currentOrderWork=$deliveryTime->currentOrderWork+1;
//                    $deliveryTime->deliver=$deliver->name;
//                    if($deliveryTime->save()){
//                        $order->save();
//                        return response()->json([
//                            'success'=>true,
//                            'message'=>$order->name.' store delivery time complete at date '.$deliveryTime->date
//                        ]);
//                    }
//                }
//                $deliveryTime->orderName=$deliveryTime->orderName.' '.$order->name;
//                $deliveryTime->currentOrderWork=$deliveryTime->currentOrderWork+1;
//                $deliveryTime->deliver=$deliver->name;
//                if($deliveryTime->save()){
//                    $order->save();
//                    return response()->json([
//                        'success'=>true,
//                        'message'=>$order->name.' store delivery time complete at date '.$deliveryTime->date
//                    ]);
//                }
//            }
//        }
//        else if($request->get('deliver') == null){
//            $deliver = "ยังไม่ลงทะเบียน";
//            $order->deliver=$deliver;
//            $deliveryTime=DeliveryTime::where('date','like','%'.$order->get('deli_date').'%')
//                ->where('time','like','%'.$order->get('deli_time').'%')
//                ->where('job','like','%'.$job.'%')->first();
//            if($deliveryTime->currentOrderWork<$deliveryTime->numOfWork){
//                if($deliveryTime->currentOrderWork==0){
//                    $deliveryTime->orderName=$order->name;
//                    $deliveryTime->currentOrderWork=$deliveryTime->currentOrderWork+1;
//                    $deliveryTime->deliver=$deliver;
//                    if($deliveryTime->save()){
//                        $order->save();
//                        return response()->json([
//                            'success'=>true,
//                            'message'=>$order->name.' store delivery time complete at date '.$deliveryTime->date
//                        ]);
//                    }
//                }
//                $deliveryTime->orderName=$deliveryTime->orderName.' '.$order->name;
//                $deliveryTime->currentOrderWork=$deliveryTime->currentOrderWork+1;
//                $deliveryTime->deliver=$deliver;
//                if($deliveryTime->save()){
//                    $order->save();
//                    return response()->json([
//                        'success'=>true,
//                        'message'=>$order->name.' store delivery time complete at date '.$deliveryTime->date
//                    ]);
//                }
//            }
//        }

//        $deliver=Employee::where('name','like','%'.$request->get('deliver').'%')->first();
//        $order->deliver=$deliver->name;



//        if($deliveryTime->currentOrderWork<$deliveryTime->numOfWork){
//            if($deliveryTime->currentOrderWork==0){
//                $deliveryTime->orderName=$order->name;
//                $deliveryTime->currentOrderWork=$deliveryTime->currentOrderWork+1;
//                if($deliveryTime->save()){
//                    $order->save();
//                    return response()->json([
//                        'success'=>true,
//                        'message'=>$order->name.' store delivery time complete at date '.$deliveryTime->date
//                    ]);
//                }
//            }
//            $deliveryTime->orderName=$deliveryTime->orderName.' '.$order->name;
//            $deliveryTime->currentOrderWork=$deliveryTime->currentOrderWork+1;
//            if($deliveryTime->save()){
//                $order->save();
//                return response()->json([
//                    'success'=>true,
//                    'message'=>$order->name.' store delivery time complete at date '.$deliveryTime->date
//                ]);
//            }
//        }
//        return response()->json([
//            'success'=>false,
//            'message'=>'store delivery time failed'
//        ]);
//    }

//
//    public function cancelDeliveryTime(Order $order){
//        $deli_date=$order->deli_date;
//        $deli_time=$order->deli_time;
//        $job="ส่งผ้า";
//        $order->deli_date=null;
//        $order->deli_time=null;
//        $order->deliver="";
//        $deliveryTime=DeliveryTime::where('date','like','%'.$deli_date.'%')
//        ->where('time','like','%'.$deli_time.'%')
//        ->where('job','like','%'.$job.'%')->first();
//        $order_name=$order->name;
//        $deliveryTime->orderName=str_replace($order_name,"",$deliveryTime->orderName);
//        $deliveryTime->currentOrderWork=$deliveryTime->currentOrderWork-1;
//        if($deliveryTime->save()){
//            $order->save();
//            return response()->json([
//                'success'=>true,
//                'message'=>'you cancel delivery time of order :'.$order_name
//            ]);
//        }
//        return response()->json([
//            'success'=>false,
//            'message'=>'cancel failed'
//        ]);
//    }
//
//    public function storePickTime(Order $order,Request $request){
//        $order->pick_date=$request->get('pick_date');
//        $order->pick_time=$request->get('pick_time');
//        $deliver=Employee::where('name','like','%'.$request->get('deliver').'%')->first();
//        $order->deliver=$deliver->name;
//        $job="รับผ้า";
//
//        $deliveryTime=DeliveryTime::where('date','like','%'.$request->get('pick_date').'%')
//        ->where('time','like','%'.$request->get('pick_time').'%')
//        ->where('job','like','%'.$job.'%')->first();
//
//
//        if($deliveryTime->currentOrderWork<$deliveryTime->numOfWork){
//            if($deliveryTime->currentOrderWork==0){
//                $deliveryTime->orderName=$order->name;
//                $deliveryTime->currentOrderWork=$deliveryTime->currentOrderWork+1;
//                if($deliveryTime->save()){
//                    $order->save();
//                    return response()->json([
//                        'success'=>true,
//                        'message'=>$order->name.' store pick time complete at date '.$deliveryTime->date
//                    ]);
//                }
//            }
//            $deliveryTime->orderName=$deliveryTime->orderName.' '.$order->name;
//            $deliveryTime->currentOrderWork=$deliveryTime->currentOrderWork+1;
//            if($deliveryTime->save()){
//                $order->save();
//                return response()->json([
//                    'success'=>true,
//                    'message'=>$order->name.' store pick time complete at date '.$deliveryTime->date
//                ]);
//            }
//        }
//        return response()->json([
//            'success'=>false,
//            'message'=>'store pick time failed'
//        ]);
//
//    }
//
//    public function cancelPickTime(Order $order){
//        $pick_date=$order->pick_date;
//        $pick_time=$order->pick_time;
//        $job="รับผ้า";
//        $order->pick_date=null;
//        $order->pick_time=null;
//        $order->deliver="";
//        $deliveryTime=DeliveryTime::where('date','like','%'.$pick_date.'%')
//        ->where('time','like','%'.$pick_time.'%')
//        ->where('job','like','%'.$job.'%')->first();
//        $order_name=$order->name;
//        $deliveryTime->orderName=str_replace($order_name,"",$deliveryTime->orderName);
//        $deliveryTime->currentOrderWork=$deliveryTime->currentOrderWork-1;
//        if($deliveryTime->save()){
//            $order->save();
//            return response()->json([
//                'success'=>true,
//                'message'=>'you cancel pick time of order :'.$order_name
//            ]);
//        }
//        return response()->json([
//            'success'=>false,
//            'message'=>'cancel failed'
//        ]);
//    }

    public function updateAppOrder(Order $order, Request $request){
        $order->deli_date=$request->get('deli_date');
        $order->deli_time=$request->get('deli_time');

        $order->save();


        $jovv = "ส่งผ้า";
        $deliv = "ยังไม่ลงทะเบียน";
        $deliveryTime=new DeliveryTime();
        $deliveryTime->date= $order->deli_date;
        $deliveryTime->time= $order->deli_time;
        $deliveryTime->orderName= $order->name;
        $deliveryTime->job= $jovv;
        $deliveryTime->deliver=$deliv;

        $deliveryTime->save();
    }

    public function acceptOrderForEmployee(Order $order){
        $employeePhone=Auth::user()->phone;
        $employee=Employee::where('phone','like','%'.$employeePhone.'%')->first();
        $order->employee_id=$employee->id;
        $order->responder=$employee->name;
        $order->status='order-confirm';

//        $order->pick_date=$request->get('pick_date') ?? null;
//        $order->pick_time=$request->get('pick_time') ?? null;
        $jovv = "รับผ้า";
        $deliv = "ยังไม่ลงทะเบียน";
        $deliveryTime=new DeliveryTime();
        $deliveryTime->date= $order->pick_date;
        $deliveryTime->time= $order->pick_time;
        $deliveryTime->orderName= $order->name;
        $deliveryTime->job= $jovv;
        $deliveryTime->deliver=$deliv;

        $deliveryTime->save();

        if($order->save()){
            return response()->json([
                'success'=>true,
                'message'=>'Order has accept by '.$employee->name,
            ],Response::HTTP_OK);
        }

        return response()->json([
            'success'=>true,
            'message'=>'accept order failed'
        ],Response::HTTP_BAD_REQUEST);
    }
//
    public function acceptOrderForDeliver(Order $order){
        $employeePhone=Auth::user()->phone;
        $employee=Employee::where('phone','like','%'.$employeePhone.'%')->first();
        $order->deliver=$employee->name;
        if($order->save()){
            return response()->json([
                'success'=>true,
                'message'=>'Order has accept by '.$employee->name,
            ],Response::HTTP_OK);
        }

        return response()->json([
            'success'=>true,
            'message'=>'accept order failed'
        ],Response::HTTP_BAD_REQUEST);
    }



    public function getTodayOrder(){
        $order = Order::whereDate('created_at',Carbon::today())->get();
        return $order;
    }
//
//    public function getIncomeToday(){
//        $order = $this->getTodayOrder();
//        $income = $order->sum('total');
//        return response()->json([
//            'income'=> $income
//        ],Response::HTTP_OK);
//    }

//    public function getNumOfCompleteOrder(){
//        $order = Order::where('status','Complete');
//        return response()->json([
//            'completeOrder'=> $order->count()
//        ],Response::HTTP_OK);
//    }

//    public function getNumOfInprogressOrder(){
//        $order = Order::where('status','in progress');
//        return response()->json([
//            'inprogress'=> $order->count()
//        ],Response::HTTP_OK);
//    }
//
//    public function getNumOfNotPayOrder(){
//        $order = Order::where('pay_status',false);
//        return response()->json([
//            'notPay'=> $order->count()
//        ],Response::HTTP_OK);
//    }

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


    public function getDashboardData(){
        $orderComplete = Order::where('status','Complete');
        $order = $this->getTodayOrder();
        $income = $order->sum('total');
        $inprogress = Order::where('status','in progress');
        $notPay = Order::where('pay_status',false);
        $customerall =Customer::all();
        $customerMem=Customer::where('isMembership',1);

        return response()->json([
            'completeOrder'=> $orderComplete->count(),
            'income'=> $income,
            'inprogress'=> $inprogress->count(),
            'notPay'=> $notPay->count(),
            'numOfCus' => $customerall->count(),
            'numOfMem' => $customerMem->count()
        ],Response::HTTP_OK);
    }












}
