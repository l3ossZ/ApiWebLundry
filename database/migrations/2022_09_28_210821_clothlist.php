<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('clothlist',function(Blueprint $table){
            $table->id();
            // order 1 --- M ClothList
            // $table->orId() ;
            // serviceRate 1 -- M ClothList
            // $table->srId() ;
            $table->integer('quantity') ;
        });
    }


    public function down()
    {
        Schema::dropIfExists('clothlist');
    }
};
