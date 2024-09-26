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
        Schema::create('sellers', function (Blueprint $table) {
            $table->id();
            $table->string('restaurant_name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('password');
            $table->string('image');
            $table->integer('city_id');
            $table->integer('neighbourhood_id');
            $table->integer('minimum_charge');
            $table->integer('delivery_fees');
            $table->string('delivery_phone');
            $table->string('delivery_whatsapp');
            $table->enum('status',['open','closed'])->default('open');
            $table->decimal('restaurant_sales',8,2)->nullable();
            $table->decimal('app_commissions',8,2)->nullable();
            $table->string('api_token')->nullable();
            $table->integer('pin_code')->nullable();
            $table->dateTime('pin_code_expires_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sellers');
    }
};
