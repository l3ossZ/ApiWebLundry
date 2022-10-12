<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\User;
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
        $customer=new Customer();
        $customer->name="Nantapat";
        $customer->phone="0223344556";
        $customer->save();

        $user= new User();
        $user->name="Nantapat";
        // $user->email="admin@example.com";
        // $user->password=Hash::make("adminpass");
        $user->phone='0223344556';
        // $user->role="เจ้าของร้าน";
        $user->realrole="customers";
        $user->save();

        $customer=new Customer();
        $customer->name="Rujipas";
        $customer->phone="0000000001";
        $customer->email="rujipas@example.com";
        $customer->save();

        $user= new User();
        $user->name="Rujipas";
        // $user->email="admin@example.com";
        // $user->password=Hash::make("adminpass");
        $user->phone='0000000001';
        // $user->role="เจ้าของร้าน";
        $user->realrole="customers";
        $user->save();
    }
}
