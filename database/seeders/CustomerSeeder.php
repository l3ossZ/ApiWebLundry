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
        // Test Customer No Membership
        $customer = new Customer() ;
        $customer->name="Customer Test";
        $customer->phone="0123456789";
        $customer->email="custest@dev.com";
        $customer->pwd=Hash::make("testtest");
        $customer->isMembership=false;
        $customer->memService=null;
        $customer->memCredit=0;
        $customer->save() ;

        $user = new User() ;
        $user->name="Customer Test";
        $user->email="custest@dev.com";
        $user->password=Hash::make("testtest");
        $user->role="CUSTOMER";
        $user->realrole="CUSTOMER";
        $user->phone="0123456789";
        $user->save() ;

        // Test Customer with Membership
        $customer = new Customer() ;
        $customer->name="Customer Mem Test";
        $customer->phone="0233445566";
        $customer->email="cusmemtest@dev.com";
        $customer->pwd=Hash::make("testtest");
        $customer->isMembership=true;
        $customer->memService="ซักรีด";
        $customer->memCredit=80;
        $customer->save() ;

        $user = new User() ;
        $user->name="Customer Mem Test";
        $user->email="cusmemtest@dev.com";
        $user->password=Hash::make("testtest");
        $user->phone="0233445566";
        $user->realrole="CUSTOMER";
        $user->role="CUSTOMER";
        $user->save() ;



//        $customer=new Customer();
//        $customer->name="Nantapat";
//        $customer->phone="0223344556";
//        $customer->save();
//
//        $user= new User();
//        $user->name="Nantapat";
//        // $user->email="admin@example.com";
//        // $user->password=Hash::make("adminpass");
//        $user->phone='0223344556';
//        // $user->role="เจ้าของร้าน";
//        $user->realrole="customers";
//        $user->save();
//
//        $customer=new Customer();
//        $customer->name="Rujipas";
//        $customer->phone="0000000001";
//        $customer->email="rujipas@example.com";
//        $customer->save();
//
//        $user= new User();
//        $user->name="Rujipas";
//        // $user->email="admin@example.com";
//        // $user->password=Hash::make("adminpass");
//        $user->phone='0000000001';
//        // $user->role="เจ้าของร้าน";
//        $user->realrole="customers";
//        $user->save();
    }
}
