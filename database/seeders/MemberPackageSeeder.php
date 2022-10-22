<?php

namespace Database\Seeders;

use App\Models\MemberPackage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MemberPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $memberpackage = new MemberPackage();
        $memberpackage->service="ซักอบ" ;
        $memberpackage->quantity=70 ;
        $memberpackage->price=700 ;
        $memberpackage->save();

        $memberpackage = new MemberPackage();
        $memberpackage->service="ซักอบ" ;
        $memberpackage->quantity=100 ;
        $memberpackage->price=900 ;
        $memberpackage->save();

        $memberpackage = new MemberPackage();
        $memberpackage->service="ซักรีด" ;
        $memberpackage->quantity=70 ;
        $memberpackage->price=800 ;
        $memberpackage->save();

        $memberpackage = new MemberPackage();
        $memberpackage->service="ซักรีด" ;
        $memberpackage->quantity=100;
        $memberpackage->price=1000 ;
        $memberpackage->save();

    }
}
