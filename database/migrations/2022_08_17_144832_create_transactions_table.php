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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('sales_type_id')->default(0);
            $table->integer('user_id');
            $table->integer('customer_id')->default(0);
            $table->string('name')->nullable();
            $table->integer('total');
            $table->string('discount')->default(0);
            $table->string('tax')->default(0);
            $table->integer('payment_id')->default(0);
            $table->boolean('status')->default(0); // 0. Pending, 1. Selesai
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
