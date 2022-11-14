<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Laundry;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class LaundrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User() ;
        $user->name="Boy Min";
        $user->email="boymin@mail.com";
        $user->password=Hash::make("password");
        $user->role="OWNER";
        $user->realrole="OWNER";
        $user->phone="0855555555";
        $user->save() ;

        $employee = new Employee();
        $employee->name="Boy Min";
        $employee->phone="0855555555";
        $employee->email="boymin@mail.com";
        $employee->role="OWNER";
        $employee->address="21 ทรายทองนิเวศน์ ซอย 5 ท่าทราย อำเภอเมืองนนทบุรี นนทบุรี 11000";
        $employee->password=Hash::make("password");
        $employee->ID_Card="1120200102031";
        $employee->bank_account_number="1020140123";
        $employee->bank_name="กสิกร";
        $employee->salary=30000.00;
        $employee->save();

        $laundry = new Laundry();
        $laundry->name="Boy Laundry";
        $laundry->phone="029155058";
        $laundry->owner="1";
        $laundry->email="mylaundryshopmail@gmail.com";
        $laundry->address="21 ทรายทองนิเวศน์ ซอย 5 ท่าทราย อำเภอเมืองนนทบุรี นนทบุรี 11000" ;
        $laundry->lineId="boyLaundryLine";
        $laundry->workDay="0111111" ;
        $laundry->opentime="09:00";
        $laundry->closetime="20:00";
        $laundry->numOfwork=3;
        $laundry->status="close";
        $laundry->save();
    }
}
