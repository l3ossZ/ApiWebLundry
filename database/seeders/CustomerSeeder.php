<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Claims\Custom;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customer = new Customer() ;
        $customer->name="Rujipas Mekarkart";
        $customer->phone="0814459956";
        $customer->email="rujipas.@ku.th";
        $customer->pwd=Hash::make("password");
        $customer->isMembership=false;
        $customer->memService="";
        $customer->memCredit=0;
        $customer->save() ;

        $user = new User() ;
        $user->name="Rujipas Mekarkart";
        $user->email="rujipas.m@ku.th";
        $user->password=Hash::make("password");
        $user->role="CUSTOMER";
        $user->realrole="CUSTOMER";
        $user->phone="0814459956";
        $user->save() ;

        $customer = new Customer() ;
        $customer->name="Hasawa Pang";
        $customer->phone="0816940895";
        $customer->email="pikhzsreoak@gmail.com";
        $customer->pwd=Hash::make("password");
        $customer->isMembership=true;
        $customer->memService="ซักรีด";
        $customer->memCredit=80;
        $customer->save() ;

        $user = new User() ;
        $user->name="Hasawa Pang";
        $user->email="pikhzsreoak@gmail.com";
        $user->password=Hash::make("password");
        $user->role="CUSTOMER";
        $user->realrole="CUSTOMER";
        $user->phone="0815855585";
        $user->save() ;

//        // Test Customer with Membership
//        $customer = new Customer() ;
//        $customer->name="Customer Mem";
//        $customer->phone="0816866686";
//        $customer->email="cusmem@dev.com";
//        $customer->pwd=Hash::make("password");
//        $customer->isMembership=true;
//        $customer->memService="ซักรีด";
//        $customer->memCredit=80;
//        $customer->save() ;
//
//        $user = new User() ;
//        $user->name="Customer Mem";
//        $user->email="cusmem@dev.com";
//        $user->password=Hash::make("password");
//        $user->phone="0816866686";
//        $user->realrole="CUSTOMER";
//        $user->role="CUSTOMER";
//        $user->save() ;

    }
}
