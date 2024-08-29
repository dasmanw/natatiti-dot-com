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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->unsignedBigInteger('warehouse_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();

            
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->decimal('length', places: 1, unsigned: true)->nullable();
            $table->decimal('height', places: 1, unsigned: true)->nullable();
            $table->decimal('width', places: 1, unsigned: true)->nullable();
            $table->text('description')->nullable();
            $table->json('prices')->nullable();
            $table->string('image_link')->nullable();

            // timestamps
            $table->timestamps();
            $table->softDeletes();

            // foreign keys
            $table->foreign('created_by')->references('id')->on('accounts');
            $table->foreign('updated_by')->references('id')->on('accounts');
            $table->foreign('vendor_id')->references('id')->on('accounts');
            $table->foreign('warehouse_id')->references('id')->on('warehouses');
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
