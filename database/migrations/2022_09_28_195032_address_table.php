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
            $table->string('name');
            $table->string('u_code');
            $table->string('lat')->nullable()->default(null);
            $table->string('lng')->nullable()->default(null);
            $table->string('hint')->nullable()->default(null);
            $table->string('contact')->nullable()->default(null);
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
