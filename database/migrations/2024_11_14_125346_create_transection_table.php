<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('transaction_id');
            $table->unsignedBigInteger('user_id');
            $table->double('amount',15,2);
            $table->enum('payment_type',['UPI','Credit Card','Debit Card']);
            $table->unsignedBigInteger('plan_id');
            $table->json('payment_option_details');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade');
            $table->foreign('plan_id')->references('plan_id')->on('plans')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transection');
    }
};
