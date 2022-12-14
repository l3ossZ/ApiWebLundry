<?php

use App\Models\Category;
use App\Models\Order;
use App\Models\ServiceRate;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('cloth_lists',function(Blueprint $table){
            $table->id();
            // $table->string('service_rate_id');
            // order 1 --- M ClothList
            // $table->orId() ;
            // serviceRate 1 -- M ClothList
            // $table->srId() ;
            $table->string('category');
            $table->integer('quantity');
            $table->string('service');
            $table->foreignIdFor(Order::class);
            // $table->foreignIdFor(ServiceRate::class);
            // $table->foreignIdFor(Category::class);
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('clothlist');
    }
};
