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
        Schema::table('settings', function (Blueprint $table) {
            if (!Schema::hasColumn('settings', 'google_map_url')) {
                $table->text('google_map_url')->nullable()->after('site_address');
            }
            if (!Schema::hasColumn('settings', 'pinterest_url')) {
                $table->string('pinterest_url')->nullable()->after('instagram_url');
            }
            if (!Schema::hasColumn('settings', 'about_text')) {
                $table->text('about_text')->nullable()->after('site_name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            //
        });
    }
};
