<?php

use App\Models\ServiceRate;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('category',function(Blueprint $table){
            $table->id();
            // Service Rate 1 -- M Category
            // $table ServiceRateID();
            $table->foreignIdFor(ServiceRate::class);
            $table->string('clothType');
            $table->double('addOnPrice');
            $table->timestamps();
            $table->softDeletes();
        });
    }


    public function down()
    {
        Schema::dropIfExists('category');
    }
};
