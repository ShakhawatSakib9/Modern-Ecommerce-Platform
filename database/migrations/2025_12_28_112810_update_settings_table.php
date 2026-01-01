<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            // Check and add youtube_url column
            if (!Schema::hasColumn('settings', 'youtube_url')) {
                $table->string('youtube_url')->nullable()->after('twitter_url');
            }

            // Check and add meta_title column
            if (!Schema::hasColumn('settings', 'meta_title')) {
                $table->string('meta_title')->nullable()->after('youtube_url');
            }

            // Check and add meta_description column
            if (!Schema::hasColumn('settings', 'meta_description')) {
                $table->string('meta_description', 500)->nullable()->after('meta_title');
            }

            // Check and add meta_keywords column
            if (!Schema::hasColumn('settings', 'meta_keywords')) {
                $table->string('meta_keywords', 500)->nullable()->after('meta_description');
            }

            // Check and add logo column
            if (!Schema::hasColumn('settings', 'logo')) {
                $table->string('logo')->nullable()->after('site_address');
            }

            // Check and add favicon column
            if (!Schema::hasColumn('settings', 'favicon')) {
                $table->string('favicon')->nullable()->after('logo');
            }
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            // Only drop columns if they exist
            if (Schema::hasColumn('settings', 'youtube_url')) {
                $table->dropColumn('youtube_url');
            }

            if (Schema::hasColumn('settings', 'meta_title')) {
                $table->dropColumn('meta_title');
            }

            if (Schema::hasColumn('settings', 'meta_description')) {
                $table->dropColumn('meta_description');
            }

            if (Schema::hasColumn('settings', 'meta_keywords')) {
                $table->dropColumn('meta_keywords');
            }

            if (Schema::hasColumn('settings', 'logo')) {
                $table->dropColumn('logo');
            }

            if (Schema::hasColumn('settings', 'favicon')) {
                $table->dropColumn('favicon');
            }
        });
    }
};
