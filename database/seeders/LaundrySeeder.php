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
        $user->name="Owner Name";
        $user->email="owner@mail.com";
        $user->password=Hash::make("password");
        $user->role="OWNER";
        $user->realrole="OWNER";
        $user->phone="0123456789";
        $user->save() ;

        $employee = new Employee();
        $employee->name="Owner Name";
        $employee->phone="0123456789";
        $employee->email="owner@mail.com";
        $employee->role="OWNER";
        $employee->address="21 ทรายทองนิเวศน์ ซอย 5 ท่าทราย อำเภอเมืองนนทบุรี นนทบุรี 11000";
        $employee->password=Hash::make("password");
        $employee->ID_Card="1105255695859";
        $employee->bank_account_number="1235856958";
        $employee->bank_name="กสิกร";
        $employee->salary=30000.00;
        $employee->save();

        $laundry = new Laundry();
        $laundry->name="Matmi shop";
        $laundry->phone="0291550580";
        $laundry->owner="1";
        $laundry->email="matmishop";
        $laundry->address="21 ทรายทองนิเวศน์ ซอย 5 ท่าทราย อำเภอเมืองนนทบุรี นนทบุรี 11000" ;
        $laundry->lineId="maimeLine";
        $laundry->workDay="0111111" ;
        $laundry->opentime="09:00";
        $laundry->closetime="20:00";
        $laundry->numOfwork=3;
        $laundry->status="close";
    }
}
