<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('service_name');
            $table->string('subtitle')->nullable();
            $table->string('category')->nullable();
            $table->string('service')->nullable();
            $table->text('description')->nullable();
            $table->string('image_path')->nullable();
            // Address fields
            $table->string('pin_code', 10)->nullable();
            $table->string('area')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('street')->nullable();
            $table->string('landmark')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            // Commercials
            $table->unsignedInteger('base_price')->nullable();
            $table->unsignedTinyInteger('discount_percent')->default(0);
            $table->decimal('rating', 3, 1)->default(5.0);
            $table->string('contact_number')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
