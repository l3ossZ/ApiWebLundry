<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;
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

        $customer=new Customer();
        $customer->name="Rujipas";
        $customer->phone="0000000001";
        $customer->email="rujipas@example.com";
        $customer->save();
    }
}
