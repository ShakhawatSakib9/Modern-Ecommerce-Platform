<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Backend\Product;
use App\Models\User;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id', 'session_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope for guest users (session based)
    public function scopeForSession($query, $sessionId)
    {
        return $query->where('session_id', $sessionId)->whereNull('user_id');
    }

    // Scope for authenticated users
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
