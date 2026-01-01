<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'sub_category_id',
        'name',
        'slug',
        'description',
        'regular_price',
        'discount_price',
        'stock_quantity',
        'sizes',
        'colors',
        'images',
        'status',
    ];

    protected $casts = [
        'regular_price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'sizes' => 'array',
        'colors' => 'array',
        'images' => 'array',
        'status' => 'string',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Calculate selling price
    public function getSellingPriceAttribute()
    {
        return $this->discount_price ?: $this->regular_price;
    }

    // Check if product is on sale
    public function getIsOnSaleAttribute()
    {
        return !is_null($this->discount_price);
    }

    // Calculate discount percentage
    public function getDiscountPercentageAttribute()
    {
        if (!$this->discount_price) return 0;

        return round((($this->regular_price - $this->discount_price) / $this->regular_price) * 100);
    }

    /**
     * Get first image URL
     */
    public function getFirstImageUrl()
    {
        if (!empty($this->images) && is_array($this->images) && count($this->images) > 0) {
            // Check if image path already has storage/ prefix
            if (strpos($this->images[0], 'storage/') === 0) {
                return asset($this->images[0]);
            }
            return asset('storage/' . $this->images[0]);
        }
        return null;
    }

    /**
     * Check if product is new (created within last 7 days)
     */
    public function isNew()
    {
        return $this->created_at->gt(now()->subDays(7));
    }
}
