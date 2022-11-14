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
            $table->string('pick_time')->nullable()->default("");
            $table->date('deli_date')->nullable()->default(null);
            $table->string('deli_time')->nullable()->default("");
            $table->string('address')->nullable()->default("");
            $table->string('responder')->nullable()->default("");
            $table->string('deliver')->nullable()->default("");
            $table->boolean('pay_status')->default(false);
            $table->string('pay_method')->default("เงินสด");
            $table->double('pick_ser_charge')->nullable()->default(0);
            $table->double('deli_ser_charge')->nullable()->default(0);
            $table->double('total')->default(0);
            $table->string('status')->default("เพิ่มรายการ");
            $table->boolean('is_membership_or')->default(false);
            $table->string('cus_phone');
            $table->foreignIdFor(Employee::class)->nullable()->constrained();
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
