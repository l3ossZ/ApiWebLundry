<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Owner
        $employee = new Employee();
        $employee->name="Owner";
        $employee->phone="029155058";
        $employee->email="myluandry@mail.com";
        $employee->role="OWNER";
        $employee->password=Hash::make("password");
        $employee->salary=30000.00;
        $employee->save();

        $user = new User() ;
        $user->name="Owner";
        $user->email="myluandry@mail.com";
        $user->phone="029155058";
        $user->role="OWNER";
        $user->realrole="OWNER";
        $user->password=Hash::make("password");
        $user->save();

        // Employee
        $employee = new Employee();
        $employee->name="Employee Test";
        $employee->phone="0811111111";
        $employee->email="employee@mail.com";
        $employee->role="EMPLOYEE";
        $employee->password=Hash::make("password");
        $employee->salary=20000.00;
        $employee->save();

        $user = new User() ;
        $user->name="Employee Test";
        $user->email="employee@mail.com";
        $user->phone="0811111111";
        $user->role="EMPLOYEE";
        $user->realrole="EMPLOYEE";
        $user->password=Hash::make("password");
        $user->save();

        // Deliver
        $employee = new Employee();
        $employee->name="Deliver Test";
        $employee->phone="082333444";
        $employee->email="deliver@mail.com";
        $employee->role="DELIVER";
        $employee->password=Hash::make("password");
        $employee->salary=18000.00;
        $employee->save();

        $user = new User() ;
        $user->name="Employee Test";
        $user->email="deliver@mail.com";
        $user->phone="082333444";
        $user->role="DELIVER";
        $user->realrole="DELIVER";
        $user->password=Hash::make("password");
        $user->save();

    }
}
