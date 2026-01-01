<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'sub_category_id',
        'name',
        'slug',
        'description',
        'short_description',
        'regular_price',
        'discount_price',
        'stock_quantity',
        'sku',
        'sizes',
        'colors',
        'images',
        'status',
        'featured',
        'is_featured',      // Add this
        'is_hot_trend',     // Add this
        'is_best_seller',   // Add this
        'view_count',       // Add this
    ];

    protected $casts = [
        'regular_price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'sizes' => 'array',
        'colors' => 'array',
        'images' => 'array',
        'status' => 'string',
        'featured' => 'boolean',
        'is_featured' => 'boolean',
        'is_hot_trend' => 'boolean',
        'is_best_seller' => 'boolean',
        'view_count' => 'integer',
    ];

    protected $appends = [
        'selling_price',
        'is_on_sale',
        'discount_percentage',
    ];

    /**
     * Relationships
     */
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

    /**
     * Accessors
     */
    public function getSellingPriceAttribute()
    {
        return $this->discount_price > 0 ? $this->discount_price : $this->regular_price;
    }

    public function getIsOnSaleAttribute()
    {
        return $this->discount_price > 0 && $this->discount_price < $this->regular_price;
    }

    public function getDiscountPercentageAttribute()
    {
        if (!$this->is_on_sale) {
            return 0;
        }

        $discount = $this->regular_price - $this->discount_price;
        return round(($discount / $this->regular_price) * 100);
    }


    public function scopeFeatured($query)
    {
        return $query->where(function($q) {
            $q->where('is_featured', true)
              ->orWhere('featured', true);
        });
    }

    public function scopeNewArrivals($query)
    {
        return $query->where('created_at', '>=', now()->subDays(30));
    }

    public function scopeOnSale($query)
    {
        return $query->where('discount_price', '>', 0)
                    ->whereColumn('discount_price', '<', 'regular_price');
    }

    /**
     * Helper Methods
     */
    public function getFirstImageUrl()
    {
        if (!empty($this->images) && is_array($this->images) && count($this->images) > 0) {
            $firstImage = $this->images[0];

            // Check if image path already has storage/ prefix
            if (strpos($firstImage, 'storage/') === 0) {
                return asset($firstImage);
            }

            // Check if image path already has full URL
            if (filter_var($firstImage, FILTER_VALIDATE_URL)) {
                return $firstImage;
            }

            return asset('storage/' . $firstImage);
        }

        return asset('frontend/img/product/default-product.jpg');
    }

    public function getImageUrls()
    {
        $urls = [];

        if (!empty($this->images) && is_array($this->images)) {
            foreach ($this->images as $image) {
                if (strpos($image, 'storage/') === 0) {
                    $urls[] = asset($image);
                } elseif (filter_var($image, FILTER_VALIDATE_URL)) {
                    $urls[] = $image;
                } else {
                    $urls[] = asset('storage/' . $image);
                }
            }
        }

        return $urls;
    }

    public function isNew()
    {
        return $this->created_at->gt(now()->subDays(7));
    }

    public function isLowStock()
    {
        return $this->stock_quantity > 0 && $this->stock_quantity <= 10;
    }

    public function isOutOfStock()
    {
        return $this->stock_quantity <= 0;
    }

    public function hasSize($size)
    {
        return in_array($size, $this->sizes ?? []);
    }

    public function hasColor($color)
    {
        return in_array($color, $this->colors ?? []);
    }

    public function getAvailableSizes()
    {
        return $this->sizes ?? [];
    }

    public function getAvailableColors()
    {
        return $this->colors ?? [];
    }

    /**
     * Increment view count
     */
    public function incrementViewCount()
    {
        $this->increment('view_count');
    }

    /**
     * Calculate total sales from order items
     */
    public function getTotalSales()
    {
        return $this->orderItems()->sum('quantity');
    }

    /**
     * Calculate total revenue from order items
     */
    public function getTotalRevenue()
    {
        return $this->orderItems()->sum('total_price');
    }
    public function scopeHotTrend($query)
    {
        return $query->where('is_hot_trend', true);
    }

    public function scopeBestSeller($query)
    {
        return $query->where('is_best_seller', true);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active')->where('stock_quantity', '>', 0);
    }
}
