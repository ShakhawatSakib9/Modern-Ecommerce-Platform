<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_name',
        'about_text',
        'site_email',
        'site_phone',
        'site_address',
        'google_map_url',
        'logo',
        'favicon',
        'delivery_charge',
        'facebook_url',
        'twitter_url',
        'instagram_url',
        'pinterest_url',
        'youtube_url',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'delivery_charge' => 'decimal:2',
    ];
}
