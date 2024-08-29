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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('salesman_id')->nullable();

            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->string('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('email')->nullable();
            $table->string('payment_method')->nullable();
            $table->decimal('total_discount', 8, 3, true)->nullable();
            $table->decimal('sub_total', 8, 3, true)->nullable();
            $table->decimal('grand_total', 8, 3, true)->nullable();
            $table->dateTime('pickup_date_time')->nullable();
            $table->dateTime('dropoff_date_time')->nullable();

            // timestamps
            $table->timestamps();

            // foreign keys
            $table->foreign('created_by')->references('id')->on('accounts');
            $table->foreign('updated_by')->references('id')->on('accounts');
            $table->foreign('salesman_id')->references('id')->on('accounts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
