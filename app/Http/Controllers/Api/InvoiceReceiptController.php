<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice_receipt;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InvoiceReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $inv=Invoice_receipt::get();
        return $inv;
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
        $inv=new Invoice_receipt();
        $inv->EMP_name=$request->get('EMP_name');
        $inv->CS_id=$request->get('CS_id');
        $inv->CS_name=$request->get('CS_name');
        $inv->CS_ADS=$request->get('CS_ADS');
        $inv->pick_date=$request->get('pick_date');
        $inv->pick_time=$request->get('pick_time');
        $inv->deli_date=$request->get('deli_date');
        $inv->deli_time=$request->get('deli_time');
        $inv->is_membership_or=$request->get('is_membership_or');
        $inv->pick_ser_charge=$request->get('pick_ser_charge');
        $inv->deli_ser_charge=$request->get('deli_ser_charge');
        $inv->deli_EMP=$request->get('deli_EMP');
        $inv->total=$request->get('total');
        $inv->pay_method=$request->get('pay_method');

        if ($inv->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Invoice Receipt created with id ' . $inv->id,
                'order_id' =>$inv->id
            ],Response::HTTP_OK);
        }
        return response()->json([
            'success' => false,
            'message' => 'Invoice Receipt create failed'
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice_receipt  $invoice_receipt
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice_receipt $invoice_receipt)
    {
        //
        return $invoice_receipt;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice_receipt  $invoice_receipt
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice_receipt $invoice_receipt)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice_receipt  $invoice_receipt
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice_receipt $invoice_receipt)
    {
        //
    }
}
