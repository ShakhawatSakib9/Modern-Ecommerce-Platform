<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Add these new fields
            $table->boolean('is_featured')->default(false)->after('status');
            $table->boolean('is_hot_trend')->default(false)->after('is_featured');
            $table->boolean('is_best_seller')->default(false)->after('is_hot_trend');
            $table->integer('view_count')->default(0)->after('is_best_seller');
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['is_featured', 'is_hot_trend', 'is_best_seller', 'view_count']);
        });
    }
};
