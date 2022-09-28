<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('servicerate',function(Blueprint $table){
            $table->id();
            $table->string('service');
            $table->double('basePrice');
        });
    }


    public function down()
    {
        Schema::dropIfExists('servicerate');
    }
};
