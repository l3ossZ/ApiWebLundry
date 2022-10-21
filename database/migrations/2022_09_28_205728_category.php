<?php

use App\Models\Category;
use App\Models\ClothList;
use App\Models\ServiceRate;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('categories',function(Blueprint $table){
            $table->id();
            // Service Rate 1 -- M Category
            // $table ServiceRateID();
            $table->foreignIdFor(ServiceRate::class);
            // $table->foreignIdFor(ClothList::class);
            $table->string('clothType');
            $table->double('addOnPrice');
            $table->timestamps();
            $table->softDeletes();
        });
    }


    public function down()
    {
        Schema::dropIfExists('categories');
    }
};
