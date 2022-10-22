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
        // Employee
        $employee = new Employee();
        $employee->name="employee 1";
        $employee->phone="0811585858";
        $employee->email="employee@mail.com";
        $employee->role="EMPLOYEE";
        $employee->address="69/12 ทรายทองนิเวศน์ ซอย 7 ท่าทราย อำเภอเมืองนนทบุรี นนทบุรี 11000";
        $employee->password=Hash::make("password");
        $employee->ID_Card="1105255656891";
        $employee->bank_account_number="1252585145";
        $employee->bank_name="กรุงเทพ";
        $employee->salary=18000.00;
        $employee->save();

        $user = new User() ;
        $user->name="employee 1";
        $user->email="employee@mail.com";
        $user->password=Hash::make("password");
        $user->role="EMPLOYEE";
        $user->realrole="EMPLOYEE";
        $user->phone="0811585858";
        $user->save() ;

        // Deliver
        $employee = new Employee();
        $employee->name="deliver 1";
        $employee->phone="0816995855";
        $employee->email="deliver@mail.com";
        $employee->role="DELIVER";
        $employee->address="2 ซอย รณสิทธิพิชัย 8/3 ตำบล ตลาดขวัญ อำเภอเมืองนนทบุรี นนทบุรี 11000";
        $employee->password=Hash::make("password");
        $employee->ID_Card="5505855859585";
        $employee->bank_account_number="2593415869";
        $employee->bank_name="ไทยภาณิข";
        $employee->salary=18000.00;
        $employee->save();

        $user = new User() ;
        $user->name="deliver 1";
        $user->email="deliver@mail.com";
        $user->password=Hash::make("password");
        $user->role="DELIVER";
        $user->realrole="DELIVER";
        $user->phone="0816995855";
        $user->save() ;
    }
}
