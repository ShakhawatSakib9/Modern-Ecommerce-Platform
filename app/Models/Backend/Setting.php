<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_name',
        'site_email',
        'site_phone',
        'site_address',
        'logo',
        'favicon',
        'delivery_charge',
        'facebook_url',
        'twitter_url',
        'instagram_url',
    ];

    protected $casts = [
        'delivery_charge' => 'decimal:2',
    ];
}
