<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Blog;
use App\Models\Backend\BlogCategory;
use App\Models\Backend\BlogComment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    // Blog listing page
    public function index()
    {
        $blogs = Blog::with('category')
            ->where('status', true)
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->paginate(9);

        $categories = BlogCategory::withCount(['blogs' => function($query) {
            $query->where('status', true);
        }])
        ->where('status', true)
        ->get();

        $featuredBlogs = Blog::with('category')
            ->where('status', true)
            ->where('featured', true)
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        // Get all tags from blogs - FIXED
        $tags = [];
        foreach ($blogs as $blog) {
            if ($blog->tags) {
                // Decode JSON string to array
                $blogTags = is_array($blog->tags) ? $blog->tags : json_decode($blog->tags, true);

                if (is_array($blogTags)) {
                    $tags = array_merge($tags, $blogTags);
                }
            }
        }
        $tags = array_unique($tags);

        return view('frontend.blog', compact('blogs', 'categories', 'featuredBlogs', 'tags'));
    }

    // Blog details page
    public function show($slug)
    {
        $blog = Blog::with(['category', 'comments'])
            ->where('slug', $slug)
            ->where('status', true)
            ->where('published_at', '<=', now())
            ->firstOrFail();

        // Increment views
        $blog->increment('views');

        // Get related blogs
        $relatedBlogs = Blog::with('category')
            ->where('blog_category_id', $blog->blog_category_id)
            ->where('id', '!=', $blog->id)
            ->where('status', true)
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        $categories = BlogCategory::withCount(['blogs' => function($query) {
            $query->where('status', true);
        }])
        ->where('status', true)
        ->get();

        $featuredBlogs = Blog::with('category')
            ->where('status', true)
            ->where('featured', true)
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        // Get all tags - FIXED
        $tags = [];
        $allBlogs = Blog::where('status', true)->get();
        foreach ($allBlogs as $item) {
            if ($item->tags) {
                $itemTags = is_array($item->tags) ? $item->tags : json_decode($item->tags, true);

                if (is_array($itemTags)) {
                    $tags = array_merge($tags, $itemTags);
                }
            }
        }
        $tags = array_unique($tags);

        // Get previous and next blog
        $previousBlog = Blog::where('status', true)
            ->where('published_at', '<=', now())
            ->where('published_at', '<', $blog->published_at)
            ->orderBy('published_at', 'desc')
            ->first();

        $nextBlog = Blog::where('status', true)
            ->where('published_at', '<=', now())
            ->where('published_at', '>', $blog->published_at)
            ->orderBy('published_at', 'asc')
            ->first();

        return view('frontend.blog-details', compact(
            'blog',
            'relatedBlogs',
            'categories',
            'featuredBlogs',
            'tags',
            'previousBlog',
            'nextBlog'
        ));
    }

    // Store comment
    public function storeComment(Request $request, $slug)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'comment' => 'required|string|min:10',
        ]);

        $blog = Blog::where('slug', $slug)->firstOrFail();

        BlogComment::create([
            'blog_id' => $blog->id,
            'name' => $request->name,
            'email' => $request->email,
            'comment' => $request->comment,
            'approved' => false, // Admin needs to approve
        ]);

        return redirect()->route('blog.details', $slug)
            ->with('success', 'Your comment has been submitted for review!');
    }

    // Search blogs
    public function search(Request $request)
    {
        $query = $request->get('search');

        $blogs = Blog::with('category')
            ->where('status', true)
            ->where('published_at', '<=', now())
            ->where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                ->orWhere('excerpt', 'like', "%{$query}%")
                ->orWhere('content', 'like', "%{$query}%");
            })
            ->orderBy('published_at', 'desc')
            ->paginate(9);

        $categories = BlogCategory::withCount(['blogs' => function($query) {
            $query->where('status', true);
        }])
        ->where('status', true)
        ->get();

        $featuredBlogs = Blog::with('category')
            ->where('status', true)
            ->where('featured', true)
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        // Get all tags - FIXED
        $tags = [];
        foreach ($blogs as $blog) {
            if ($blog->tags) {
                $blogTags = is_array($blog->tags) ? $blog->tags : json_decode($blog->tags, true);

                if (is_array($blogTags)) {
                    $tags = array_merge($tags, $blogTags);
                }
            }
        }
        $tags = array_unique($tags);

        return view('frontend.blog', compact('blogs', 'categories', 'featuredBlogs', 'query', 'tags'));
    }
}
