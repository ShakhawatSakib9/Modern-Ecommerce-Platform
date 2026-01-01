<?php

namespace Database\Seeders;

use App\Models\Backend\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        // First, get the table columns
        $settings = [
            'site_name' => 'Clothing Store',
            'site_email' => 'info@clothingstore.com',
            'site_phone' => '+1 (234) 567-8900',
            'site_address' => '123 Fashion Street, New York, NY 10001',
            'delivery_charge' => 5.00,
        ];

        // Add optional columns only if they exist in the database
        if (Schema::hasColumn('settings', 'facebook_url')) {
            $settings['facebook_url'] = 'https://facebook.com/clothingstore';
        }

        if (Schema::hasColumn('settings', 'instagram_url')) {
            $settings['instagram_url'] = 'https://instagram.com/clothingstore';
        }

        if (Schema::hasColumn('settings', 'twitter_url')) {
            $settings['twitter_url'] = 'https://twitter.com/clothingstore';
        }

        if (Schema::hasColumn('settings', 'youtube_url')) {
            $settings['youtube_url'] = 'https://youtube.com/clothingstore';
        }

        if (Schema::hasColumn('settings', 'meta_title')) {
            $settings['meta_title'] = 'Clothing Store - Fashion for Everyone';
        }

        if (Schema::hasColumn('settings', 'meta_description')) {
            $settings['meta_description'] = 'Best clothing store with latest fashion trends for men, women, and kids.';
        }

        if (Schema::hasColumn('settings', 'meta_keywords')) {
            $settings['meta_keywords'] = 'clothing, fashion, store, shop, online shopping';
        }

        Setting::create($settings);
    }
}
