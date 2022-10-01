<?php

namespace Database\Seeders;

use App\Models\ServiceRate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $service_rate=new ServiceRate();
        $service_rate->service="ซักอบ";
        $service_rate->basePrice=15;
        $service_rate->save();

        $service_rate=new ServiceRate();
        $service_rate->service="ซักรีด";
        $service_rate->basePrice=25;
        $service_rate->save();

        $service_rate=new ServiceRate();
        $service_rate->service="ซักแห้ง";
        $service_rate->basePrice=80;
        $service_rate->save();

        $service_rate=new ServiceRate();
        $service_rate->service="รีด";
        $service_rate->basePrice=10;
        $service_rate->save();




    }
}
