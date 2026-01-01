<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Add new fields if they don't exist
            if (!Schema::hasColumn('products', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('status');
            }

            if (!Schema::hasColumn('products', 'is_hot_trend')) {
                $table->boolean('is_hot_trend')->default(false)->after('is_featured');
            }

            if (!Schema::hasColumn('products', 'is_best_seller')) {
                $table->boolean('is_best_seller')->default(false)->after('is_hot_trend');
            }

            if (!Schema::hasColumn('products', 'view_count')) {
                $table->integer('view_count')->default(0)->after('is_best_seller');
            }

            // Add short_description if it doesn't exist
            if (!Schema::hasColumn('products', 'short_description')) {
                $table->text('short_description')->nullable()->after('description');
            }

            // Add SKU if it doesn't exist
            if (!Schema::hasColumn('products', 'sku')) {
                $table->string('sku', 100)->nullable()->unique()->after('stock_quantity');
            }
        });

        // Migrate existing featured products to new field
        DB::statement("UPDATE products SET is_featured = featured WHERE featured IS NOT NULL");
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['is_featured', 'is_hot_trend', 'is_best_seller', 'view_count']);
        });
    }
};
