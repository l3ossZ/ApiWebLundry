<?php

use App\Models\Employee;
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
        Schema::create('orders',function(Blueprint $table){
            $table->id();
            $table->timestamps();
            $table->string('service');
            $table->string('name')->unique();
            $table->date('pick_date')->nullable()->default(null);
            $table->string('pick_time')->nullable()->default(null);
            $table->date('deli_date')->nullable()->default(null);
            $table->string('deli_time')->nullable()->default(null);
            $table->string('address')->nullable()->default(null);
            $table->string('responder');
            $table->string('deliver')->nullable()->default(null);
            $table->boolean('pay_status')->default(false);
            $table->string('pay_method')->default("เงินสด");
            $table->double('pick_ser_charge')->nullable()->default(0);
            $table->double('deli_ser_charge')->nullable()->default(0);
            $table->double('total')->default(0);
            $table->string('status')->default("Order Add");
            $table->boolean('is_membership_or')->default(false);
            $table->string('cus_phone');
            $table->foreignIdFor(Employee::class);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
