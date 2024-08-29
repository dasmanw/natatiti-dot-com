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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('salesman_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();

            $table->string('price_type');
            $table->decimal('discount', 8, 3, true)->default(0);
            $table->decimal('net_total', 8, 3, true)->nullable();
            $table->decimal('total', 8, 3, true)->nullable();
            $table->dateTime('pickup_date_time')->nullable();
            $table->dateTime('dropoff_date_time')->nullable();

            $table->timestamps();

            // foreign keys
            $table->foreign('created_by')->references('id')->on('accounts');
            $table->foreign('updated_by')->references('id')->on('accounts');
            $table->foreign('salesman_id')->references('id')->on('accounts');
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
