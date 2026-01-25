<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'blog_id',
        'name',
        'email',
        'comment',
        'likes',
        'shares',
        'approved'
    ];

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }

    public function getCommentDateAttribute()
    {
        return $this->created_at->format('M d, Y');
    }
}
