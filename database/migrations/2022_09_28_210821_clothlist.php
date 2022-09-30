<?php

use App\Models\Order;
use App\Models\ServiceRate;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('clothlist',function(Blueprint $table){
            $table->id();
            $table->foreignIdFor(Order::class);
            $table->foreignIdFor(ServiceRate::class);
            // order 1 --- M ClothList
            // $table->orId() ;
            // serviceRate 1 -- M ClothList
            // $table->srId() ;
            $table->integer('quantity') ;
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('clothlist');
    }
};
