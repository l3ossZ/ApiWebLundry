<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EmployeeController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth:api');
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees=Employee::get();
        $user=auth()->user();
        return [$employees,$user];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $employee=new Employee();
        $employee->name=$request->get('name');
        $employee->phone=$request->get('phone');
        $employee->email=$request->get('email');
        $employee->role=$request->get('role');
        // $employee->username=$request->get('username');
        $employee->password=bcrypt($request->get('password'));
        $employee->salary=$request->get('salary');

        $user=new User();
        $user->name=$request->get('name');
        $user->phone=$request->get('phone');
        $user->email=$request->get('email');
        $user->role=$request->get('role');
        $user->realrole="employee";
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



        if($request->has('name')) $user->name=$request->get('name');
        if($request->has('phone')) $user->phone=$request->get('phone');
        if($request->has('email')) $user->email=$request->get('email');
        if($request->has('role')) $user->role=$request->get('role');
        $user->realrole="employee";
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
        $name=$employee->name;
        if($employee->delete()){
            return response()->json([
                'success' => true,
                'message' => "Employee {$name} has been deleted"
            ], Response::HTTP_OK);
        }
        return response()->json([
            'success' => false,
            'message' => "Employee {$name} delete failed"
        ], Response::HTTP_BAD_REQUEST);
    }
}
