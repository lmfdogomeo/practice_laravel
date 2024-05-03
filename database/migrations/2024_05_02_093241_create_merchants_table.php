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
        Schema::create('merchants', function (Blueprint $table) {
            $table->id();
            $table->uuid("uuid")->unique();
            $table->string('company_name', 255);
            $table->string("company_tax_id", 100)->unique();
            $table->string("contact_number", 50);
            $table->string("address", 255);
            // $table->bigInteger("user_id")->index()->unsigned();
            // $table->foreign("user_id")->references("id")->on("users");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merchants');
    }
};
