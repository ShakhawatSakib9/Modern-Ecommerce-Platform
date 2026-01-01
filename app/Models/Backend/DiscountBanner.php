<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class DiscountBanner extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'image',
        'discount_percentage',
        'discount_code',
        'end_date',
        'is_active',
    ];

    protected $casts = [
        'discount_percentage' => 'decimal:2',
        'is_active' => 'boolean',
        'end_date' => 'datetime',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->latest();
    }

    public function getImageUrl()
    {
        if (!$this->image) return asset('frontend/img/discount.jpg');

        if (strpos($this->image, 'storage/') === 0) {
            return asset($this->image);
        }
        return asset('storage/' . $this->image);
    }

}
