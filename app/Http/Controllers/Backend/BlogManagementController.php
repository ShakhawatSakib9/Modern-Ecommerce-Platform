<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Blog;
use App\Models\Backend\BlogCategory;
use App\Models\Backend\BlogComment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BlogManagementController extends Controller
{
    /**
     * Display a listing of blog posts.
     */
    public function index()
    {
        $blogs = Blog::with('category')->latest()->paginate(10);
        return view('backend.blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new blog post.
     */
    public function create()
    {
        $categories = BlogCategory::where('status', true)->get();
        return view('backend.blogs.create', compact('categories'));
    }

    /**
     * Store a newly created blog post.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255|unique:blogs',
            'blog_category_id' => 'required|exists:blog_categories,id',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'author' => 'nullable|string|max:255',
            'tags' => 'nullable|string',
            'featured' => 'boolean',
            'status' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->except('image');
        $data['slug'] = Str::slug($request->title);

        // Parse tags
        if ($request->tags) {
            $tags = array_map('trim', explode(',', $request->tags));
            $data['tags'] = json_encode($tags);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $imageName = time() . '_' . Str::slug($request->title) . '.' . $request->image->extension();
            $request->image->storeAs('public/blogs', $imageName);
            $data['image'] = $imageName;
        }

        Blog::create($data);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post created successfully!');
    }

    /**
     * Display the specified blog post.
     */
    public function show(Blog $blog)
    {
        $blog->load('category', 'comments');
        return view('backend.blogs.show', compact('blog'));
    }

    /**
     * Show the form for editing the blog post.
     */
    public function edit(Blog $blog)
    {
        $categories = BlogCategory::where('status', true)->get();
        return view('backend.blogs.edit', compact('blog', 'categories'));
    }

    /**
     * Update the specified blog post.
     */
    public function update(Request $request, Blog $blog)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255|unique:blogs,title,' . $blog->id,
            'blog_category_id' => 'required|exists:blog_categories,id',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'author' => 'nullable|string|max:255',
            'tags' => 'nullable|string',
            'featured' => 'boolean',
            'status' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->except('image');
        $data['slug'] = Str::slug($request->title);

        // Parse tags
        if ($request->tags) {
            $tags = array_map('trim', explode(',', $request->tags));
            $data['tags'] = json_encode($tags);
        } elseif ($blog->tags) {
            $data['tags'] = $blog->tags;
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($blog->image && Storage::exists('public/blogs/' . $blog->image)) {
                Storage::delete('public/blogs/' . $blog->image);
            }

            $imageName = time() . '_' . Str::slug($request->title) . '.' . $request->image->extension();
            $request->image->storeAs('public/blogs', $imageName);
            $data['image'] = $imageName;
        }

        $blog->update($data);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post updated successfully!');
    }

    /**
     * Remove the specified blog post.
     */
    public function destroy(Blog $blog)
    {
        // Delete image
        if ($blog->image && Storage::exists('public/blogs/' . $blog->image)) {
            Storage::delete('public/blogs/' . $blog->image);
        }

        // Delete comments
        $blog->comments()->delete();

        $blog->delete();

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post deleted successfully!');
    }

    /**
     * Toggle blog status.
     */
    public function toggleStatus(Blog $blog)
    {
        $blog->update(['status' => !$blog->status]);
        return response()->json(['success' => true]);
    }

    /**
     * Toggle featured status.
     */
    public function toggleFeatured(Blog $blog)
    {
        $blog->update(['featured' => !$blog->featured]);
        return response()->json(['success' => true]);
    }

    /**
     * Manage blog comments.
     */
    public function comments()
    {
        $comments = BlogComment::with('blog')->latest()->paginate(15);
        return view('backend.blogs.comments', compact('comments'));
    }
    /**
     * Toggle comment approval.
     */
    public function toggleCommentApproval(BlogComment $comment)
    {
        $comment->update(['approved' => !$comment->approved]);
        return response()->json(['success' => true]);
    }

    /**
     * Delete comment.
     */
    public function destroyComment(BlogComment $comment)
    {
        $comment->delete();
        return redirect()->route('admin.blog-comments.index')
            ->with('success', 'Comment deleted successfully!');
    }
}
