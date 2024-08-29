<?php

use App\Models\User;
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
        Schema::create('accounts', function (Blueprint $table) {
            // IDs
            $table->id();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();

            // general
            $table->string('name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->enum('status', User::$statuses)->default(User::APPROVED);
            $table->string('phone_number')->nullable();
            $table->string('address')->nullable();

            // accounts
            $table->boolean('showable')->default(true);

            // other
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();

            // timestamps
            $table->timestamps();
            $table->softDeletes();

            // foreign keys
            $table->foreign('created_by')->references('id')->on('accounts');
            $table->foreign('updated_by')->references('id')->on('accounts');
            $table->foreign('parent_id')->references('id')->on('accounts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
