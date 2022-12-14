<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;



class EmployeeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => 'changePassword']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     /**
     * @OA\Get(
     *     path="/employees",
     *     operationId="employeeAll",
     *     tags={"Employee"},
     *     security={
     *           {"bearerAuth": {}}
     *       },
     *     @OA\Response(
     *         response="200",
     *         description="Everything is fine",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/EmployeeResource"),
     *             )
     *         )
     *     ),
     * )
     */
    public function index()
    {
        $employees=Employee::get();
        return EmployeeResource::collection($employees);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     /**
      * @OA\Post(
     *     path="/employees",
     *     operationId="employeeCreate",
     *     tags={"Employee"},
     *     summary="Create yet another employee record",
     *     security={
     *           {"bearerAuth": {}}
     *       },
     *     @OA\Response(
     *         response="200",
     *         description="Everything is fine",
     *         @OA\JsonContent(ref="#/components/schemas/EmployeeResource")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/EmployeeRequest")
     *     ),
     * )
      */
    public function store(Request $request)
    {
        $employee=new Employee();
        $employee->name=$request->get('name');
        $employee->phone=$request->get('phone');
        $employee->email=$request->get('email');
        $employee->role=$request->get('role');
        $employee->password=bcrypt($request->get('password'));
        $employee->salary=$request->get('salary');
        $employee->address=$request->get('address');
        $employee->ID_Card=$request->get('ID_Card');
        $employee->bank_account_number=$request->get('bank_account_number');
        $employee->bank_name=$request->get('bank_name');


       $user=new User();
       $user->name=$request->get('name');
       $user->phone=$request->get('phone');
       $user->email=$request->get('email');
       $user->role=$request->get('role');
       $user->realrole="EMPLOYEE";
       $user->password=bcrypt($request->get('password'));
       $user->save();


        if ($employee->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Employee created with id ' . $employee->id,
                'employee_id' =>$employee->id
            ],Response::HTTP_CREATED);
        }
        return response()->json([
            'success' => false,
            'message' => 'Employee creation failed'
        ], Response::HTTP_BAD_REQUEST);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */

     /**
     * @OA\Get(
     *     path="/employees/{id}",
     *     operationId="employeeGetId",
     *     tags={"Employee"},
     *     security={
     *           {"bearerAuth": {}}
     *       },
     *     summary="Get Employee by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="The ID of employee",
     *         required=true,
     *         example="1",
     *         @OA\Schema(
     *             type="integer",
     *         ),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Everything is fine",
     *         @OA\JsonContent(ref="#/components/schemas/EmployeeResource")
     *     ),
     * )
      */
    public function show(Employee $employee)
    {
        //
        return $employee;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */

     /**
      * @OA\Put(
     *     path="/employees/{id}",
     *     operationId="employeeUpdate",
     *     tags={"Employee"},
     *     summary="Update Employee by ID",
     *     security={
     *           {"bearerAuth": {}}
     *       },
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="The ID of employee",
     *         required=true,
     *         example="1",
     *         @OA\Schema(
     *             type="integer",
     *         ),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Everything is fine",
     *         @OA\JsonContent(ref="#/components/schemas/EmployeeResource")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/EmployeeRequest")
     *     ),
     * )
      */
    public function update(Request $request, Employee $employee)
    {
        $user=User::where('email','like','%'.$employee->email.'%')->first();

        if($request->has('name')) $employee->name=$request->get('name');
        if($request->has('phone')) $employee->phone=$request->get('phone');
        if($request->has('email')) $employee->email=$request->get('email');
        if($request->has('role')) $employee->role=$request->get('role');
        // if($request->has('username')) $employee->username=$request->get('username');
        if($request->has('password')) $employee->password=bcrypt($request->get('password'));
        if($request->has('salary')) $employee->salary=$request->get('salary');
        if($request->has('address')) $employee->address=$request->get('address');
        if($request->has('ID_Card')) $employee->ID_Card=$request->get('ID_Card');
        if($request->has('bank_account_number')) $employee->bank_account_number=$request->get('bank_account_number');
        if($request->has('bank_name')) $employee->bank_name=$request->get('bank_name');


        if($request->has('name')) $user->name=$request->get('name');
        if($request->has('phone')) $user->phone=$request->get('phone');
        if($request->has('email')) $user->email=$request->get('email');
        if($request->has('role')) $user->role=$request->get('role');
        if($request->has('role')) $user->role=$request->get('realrole');
//        $user->realrole="employee";
        if($request->has('password')) $user->password=bcrypt($request->get('password'));
        $user->save();

        if ($employee->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Employee updated with id ' . $employee->id,
                'employee_id' =>$employee->id
            ],Response::HTTP_OK);
        }
        return response()->json([
            'success' => false,
            'message' => 'Employee update failed'
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        //
        $phone=$employee->phone;
        $user=User::where('phone','like','%'.$phone.'%')->first();
        if($employee->delete()){
            $user->delete();
            return response()->json([
                'success' => true,
                'message' => "Employee {$phone} has been deleted"
            ], Response::HTTP_OK);
        }
        return response()->json([
            'success' => false,
            'message' => "Employee {$phone} delete failed"
        ], Response::HTTP_BAD_REQUEST);
    }

    public function changePassword(Request $request){
        $employee = Employee::where('ID_Card','like','%'.$request->get('ID_Card').'%')->first();
        if($request->get('ID_Card') == $employee->ID_Card){
            $user=User::where('email','like','%'.$employee->email.'%')->first();
            $pwd = "";
            if($request->has('password')){
                $pwd = bcrypt($request->get('password'));
                $employee->password = $pwd;
                $user->password = $pwd;
            }
//            if($request->has('password')) $user->password=bcrypt($request->get('password'));
            $user->save();
            if ($employee->save()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Change password Complete' . $employee->id,
                    'employee'=> $employee,
                    'employee_id' =>$employee->id
                ],Response::HTTP_OK);
            }
            return response()->json([
                'success' => false,
                'message' => 'Change password Faild'
            ], Response::HTTP_BAD_REQUEST);
        }
        else{
            return response()->json([
                'success' => false,
                'message' => 'Change password Faild'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
