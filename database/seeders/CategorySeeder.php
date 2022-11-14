<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // ซักอบประเภทผ้า base price = 15
        $category = new Category();
        $category->service_rate_id=1;
        $category->clothType="เสื้อยืดแขนสั้น";
        $category->addOnPrice=0.00;
        $category->save();

        $category = new Category();
        $category->service_rate_id=1;
        $category->clothType="เสื้อยืดแขนยาว";
        $category->addOnPrice=5.00;
        $category->save();

        $category = new Category();
        $category->service_rate_id=1;
        $category->clothType="กาเกงขาสั้น";
        $category->addOnPrice=0.00;
        $category->save();

        $category = new Category();
        $category->service_rate_id=1;
        $category->clothType="กาเกงขายาว";
        $category->addOnPrice=5.00;
        $category->save();

        $category = new Category();
        $category->service_rate_id=1;
        $category->clothType="กาเกงยีนต์";
        $category->addOnPrice=10.00;
        $category->save();

        $category = new Category();
        $category->service_rate_id=1;
        $category->clothType="กระโปรง";
        $category->addOnPrice=5.00;
        $category->save();



        // ซักรีดประเภทผ้า base is 25 baht

        $category = new Category();
        $category->service_rate_id=2;
        $category->clothType="เสื้อเชิ้ตแขนยาว";
        $category->addOnPrice=5.00;
        $category->save();

        $category = new Category();
        $category->service_rate_id=2;
        $category->clothType="เสื้อเชิ้ตแขนสั้น";
        $category->addOnPrice=0.00;
        $category->save();

        $category = new Category();
        $category->service_rate_id=2;
        $category->clothType="กางเกงขายาว";
        $category->addOnPrice=5.00;
        $category->save();

        $category = new Category();
        $category->service_rate_id=2;
        $category->clothType="กางเกงขาสั้น";
        $category->addOnPrice=0.00;
        $category->save();


        $category = new Category();
        $category->service_rate_id=2;
        $category->clothType="การเกงยีนส์";
        $category->addOnPrice=10.00;
        $category->save();

        $category = new Category();
        $category->service_rate_id=2;
        $category->clothType="กระโปรงยาว";
        $category->addOnPrice=10.00;
        $category->save();

        $category = new Category();
        $category->service_rate_id=2;
        $category->clothType="กระโปรงสั้น";
        $category->addOnPrice=5.00;
        $category->save();

        $category = new Category();
        $category->service_rate_id=2;
        $category->clothType="ผ้าเช็ดตัว";
        $category->addOnPrice=5.00;
        $category->save();

        $category = new Category();
        $category->service_rate_id=2;
        $category->clothType="ถุงเท้า";
        $category->addOnPrice= -10.00;
        $category->save();

        $category = new Category();
        $category->service_rate_id=2;
        $category->clothType="กางเกงใน";
        $category->addOnPrice=-10.00;
        $category->save();

        $category = new Category();
        $category->service_rate_id=2;
        $category->clothType="เสื้อสตรี";
        $category->addOnPrice=25.00;
        $category->save();

        $category = new Category();
        $category->service_rate_id=2;
        $category->clothType="เสื้อชั้นในสตรี";
        $category->addOnPrice=-7.00;
        $category->save();

        $category = new Category();
        $category->service_rate_id=2;
        $category->clothType="ปอกหมอน";
        $category->addOnPrice=0.00;
        $category->save();

        $category = new Category();
        $category->service_rate_id=2;
        $category->clothType="ผ้านวมเล็ก";
        $category->addOnPrice=0.00;
        $category->save();


        $category = new Category();
        $category->service_rate_id=2;
        $category->clothType="ผ้านวมใหญ่";
        $category->addOnPrice=135.00;
        $category->save();

        $category = new Category();
        $category->service_rate_id=2;
        $category->clothType="ตุ๊กตาตัวใหญ่";
        $category->addOnPrice=175.00;
        $category->save();

        $category = new Category();
        $category->service_rate_id=2;
        $category->clothType="ตุ๊กตาตัวกลาง";
        $category->addOnPrice=125.00;
        $category->save();

        $category = new Category();
        $category->service_rate_id=2;
        $category->clothType="ตุ๊กตาตัวเล็ก";
        $category->addOnPrice=85.00;
        $category->save();



        // ซักแห้งประเภทผ้า base price = 80
        $category = new Category();
        $category->service_rate_id=3;
        $category->clothType="สูท";
        $category->addOnPrice=10.00;
        $category->save();

        $category = new Category();
        $category->service_rate_id=3;
        $category->clothType="แจ๊คเก็ต";
        $category->addOnPrice=20.00;
        $category->save();

        $category = new Category();
        $category->service_rate_id=3;
        $category->clothType="โค้ท";
        $category->addOnPrice=120.00;
        $category->save();

        $category = new Category();
        $category->service_rate_id=3;
        $category->clothType="โอเวอร์โค้ท";
        $category->addOnPrice=170.00;
        $category->save();

        $category = new Category();
        $category->service_rate_id=3;
        $category->clothType="เสื้อซาฟารี";
        $category->addOnPrice=40.00;
        $category->save();

        $category = new Category();
        $category->service_rate_id=3;
        $category->clothType="เสื้อเชิ้ต";
        $category->addOnPrice=0.00;
        $category->save();

        $category = new Category();
        $category->service_rate_id=3;
        $category->clothType="เสื้อยืด";
        $category->addOnPrice=-30.00;
        $category->save();

        $category = new Category();
        $category->service_rate_id=3;
        $category->clothType="เสื้อกั๊ก";
        $category->addOnPrice=-20.00;
        $category->save();

        $category = new Category();
        $category->service_rate_id=3;
        $category->clothType="เสื้อลำลอง";
        $category->addOnPrice=-10.00;
        $category->save();

        $category = new Category();
        $category->service_rate_id=3;
        $category->clothType="กางเกง";
        $category->addOnPrice=0.00;
        $category->save();


        $category = new Category();
        $category->service_rate_id=3;
        $category->clothType="เนคไทด์";
        $category->addOnPrice=-50.00;
        $category->save();

        $category = new Category();
        $category->service_rate_id=3;
        $category->clothType="เสื้อสตรี";
        $category->addOnPrice=-10.00;
        $category->save();



        $category = new Category();
        $category->service_rate_id=3;
        $category->clothType="กระโปรง";
        $category->addOnPrice=0.00;
        $category->save();

        $category = new Category();
        $category->service_rate_id=3;
        $category->clothType="กระโปรงพรีท";
        $category->addOnPrice=220.00;
        $category->save();

        $category = new Category();
        $category->service_rate_id=3;
        $category->clothType="ชุดเดรส";
        $category->addOnPrice=70.00;
        $category->save();

        $category = new Category();
        $category->service_rate_id=3;
        $category->clothType="ชุดราตรี";
        $category->addOnPrice=220.00;
        $category->save();

        $category = new Category();
        $category->service_rate_id=3;
        $category->clothType="ชุดรับปริญญา";
        $category->addOnPrice=120.00;
        $category->save();

        $category = new Category();
        $category->service_rate_id=3;
        $category->clothType="สเว็ตเตอร์";
        $category->addOnPrice=120.00;
        $category->save();

        $category = new Category();
        $category->service_rate_id=3;
        $category->clothType="ผ้าพันคอ";
        $category->addOnPrice=-20.00;
        $category->save();

        $category = new Category();
        $category->service_rate_id=3;
        $category->clothType="ผ้านวมผืนใหญ่";
        $category->addOnPrice=170.00;
        $category->save();

        $category = new Category();
        $category->service_rate_id=3;
        $category->clothType="ผ้าพันคอ";
        $category->addOnPrice=120.00;
        $category->save();


        // รีด base price = 10

        $category = new Category();
        $category->service_rate_id=4;
        $category->clothType="เสื้อยืดแขนสั้น";
        $category->addOnPrice=0.00;
        $category->save();

        $category = new Category();
        $category->service_rate_id=4;
        $category->clothType="เสื้อยืดแขนยาว";
        $category->addOnPrice=5.00;
        $category->save();

        $category = new Category();
        $category->service_rate_id=4;
        $category->clothType="กาเกงขาสั้น";
        $category->addOnPrice=0.00;
        $category->save();

        $category = new Category();
        $category->service_rate_id=4;
        $category->clothType="กาเกงขายาว";
        $category->addOnPrice=5.00;
        $category->save();

        $category = new Category();
        $category->service_rate_id=4;
        $category->clothType="กาเกงยีนต์";
        $category->addOnPrice=10.00;
        $category->save();

        $category = new Category();
        $category->service_rate_id=4;
        $category->clothType="กระโปรง";
        $category->addOnPrice=5.00;
        $category->save();
    }
}
