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
           $table->string('email')->unique();
           $table->string('pwd')->nullable();
           $table->boolean('isMembership')->default(false);
           $table->string('memService')->nullable(null);
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
