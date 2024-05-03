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
        Schema::create('merchant_users', function (Blueprint $table) {
            $table->id();
            $table->uuid("uuid")->unique();
            $table->bigInteger("user_id")->index()->unsigned();
            $table->bigInteger("merchant_id")->index()->unsigned();
            $table->foreign("user_id")->references("id")->on("users");
            $table->foreign("merchant_id")->references("id")->on("merchants");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merchant_users');
    }
};
