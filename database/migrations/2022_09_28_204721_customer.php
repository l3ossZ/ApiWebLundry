<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('customers',function(Blueprint $table){
           $table->id();
           $table->string('name');
           $table->string('phone')->unique();
           $table->string('email')->unique()->nullable()->default(null);
           $table->string('pwd')->nullable()->default(null);
           $table->boolean('isMembership')->default(false);
           $table->string('memService')->nullable()->default(null);
           $table->integer('memCredit')->nullable()->default(0) ;
           $table->timestamps();
           $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customers');
    }
};
