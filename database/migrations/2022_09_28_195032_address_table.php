<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses',function(Blueprint $table){
            $table->id();
            $table->string('name')->nullable()->default("-");
            $table->string('u_code');
            $table->double('lat')->nullable()->default(0.00);
            $table->double('lng')->nullable()->default(0.00);
            $table->string('hint')->nullable()->default("-");
            $table->string('contact')->nullable()->default("-");
            $table->string('cus_phone');
            $table->timestamps();
            $table->softDeletes();
        });
        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
};
