<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'status'
    ];

    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    public function getBlogCountAttribute()
    {
        return $this->blogs()->where('status', true)->count();
    }
}
