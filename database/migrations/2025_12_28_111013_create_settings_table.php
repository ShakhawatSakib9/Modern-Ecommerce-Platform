<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->default('Clothing Store');
            $table->string('site_email')->default('info@clothingstore.com');
            $table->string('site_phone')->default('+1234567890');
            $table->text('site_address')->nullable();
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->decimal('delivery_charge', 10, 2)->default(0);
            $table->string('facebook_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
