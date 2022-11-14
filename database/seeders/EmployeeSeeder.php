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
        $employee->name="ภูบดี โรมินทร์";
        $employee->phone="0896789567";
        $employee->email="phubadee@mail.com";
        $employee->role="EMPLOYEE";
        $employee->address="69/12 ทรายทองนิเวศน์ ซอย 7 ท่าทราย อำเภอเมืองนนทบุรี นนทบุรี 11000";
        $employee->password=Hash::make("password");
        $employee->ID_Card="1102422034123";
        $employee->bank_account_number="2394029323";
        $employee->bank_name="กสิกรไทย";
        $employee->salary=18000.00;
        $employee->save();

        $user = new User() ;
        $user->name="ภูบดี โรมินทร์";
        $user->email="phubadee@mail.com";
        $user->password=Hash::make("password");
        $user->role="EMPLOYEE";
        $user->realrole="EMPLOYEE";
        $user->phone="0896789567";
        $user->save() ;

        $employee = new Employee();
        $employee->name="Pakorn Phuna";
        $employee->phone="0896781568";
        $employee->email="pakorn@mail.com";
        $employee->role="EMPLOYEE";
        $employee->address="69/12 ทรายทองนิเวศน์ ซอย 7 ท่าทราย อำเภอเมืองนนทบุรี นนทบุรี 11000";
        $employee->password=Hash::make("password");
        $employee->ID_Card="1102421034123";
        $employee->bank_account_number="2314029323";
        $employee->bank_name="กสิกรไทย";
        $employee->salary=18000.00;
        $employee->save();

        $user = new User() ;
        $user->name="Pakorn Phuna";
        $user->email="pakorn@mail.com";
        $user->password=Hash::make("password");
        $user->role="EMPLOYEE";
        $user->realrole="EMPLOYEE";
        $user->phone="0896781568";
        $user->save() ;

        // Deliver
        $employee = new Employee();
        $employee->name="ชัชชาย จัทร์เพชร์";
        $employee->phone="0816995855";
        $employee->email="chatchai@mail.com";
        $employee->role="DELIVER";
        $employee->address="2 ซอย รณสิทธิพิชัย 8/3 ตำบล ตลาดขวัญ อำเภอเมืองนนทบุรี นนทบุรี 11000";
        $employee->password=Hash::make("password");
        $employee->ID_Card="5505815859585";
        $employee->bank_account_number="2593215869";
        $employee->bank_name="ไทยภาณิข";
        $employee->salary=18000.00;
        $employee->save();

        $user = new User() ;
        $user->name="ชัชชาย จัทร์เพชร์";
        $user->email="deliver@mail.com";
        $user->password=Hash::make("password");
        $user->role="DELIVER";
        $user->realrole="DELIVER";
        $user->phone="0816995855";
        $user->save() ;
    }
}
