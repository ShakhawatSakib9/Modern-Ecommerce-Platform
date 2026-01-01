<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\InstagramPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InstagramPostController extends Controller
{
    public function index()
    {
        $posts = InstagramPost::latest()->paginate(10);
        return view('backend.instagram_posts.index', compact('posts'));
    }

    public function create()
    {
        // Get next order number (last order + 1)
        $nextOrder = (InstagramPost::max('order') ?? 0) + 1;

        return view('backend.instagram_posts.create', compact('nextOrder'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'caption' => 'nullable|string|max:100',
            'link' => 'nullable|url|max:255',
            'order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        // Upload image
        $imagePath = $request->file('image')->store('instagram', 'public');

        // Auto-increment order if 0 or empty
        $order = $request->order;
        if ($order == 0 || empty($order)) {
            $lastOrder = InstagramPost::max('order') ?? 0;
            $order = $lastOrder + 1;
        }

        InstagramPost::create([
            'image' => $imagePath,
            'caption' => $request->caption,
            'link' => $request->link,
            'order' => $order,
            'is_active' => $request->filled('is_active'),
        ]);

        return redirect()->route('admin.instagram-posts.index')
            ->with('success', 'Instagram post created successfully.');
    }

    public function edit(InstagramPost $instagramPost)
    {
        return view('backend.instagram_posts.edit', compact('instagramPost'));
    }

    public function update(Request $request, InstagramPost $instagramPost)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'caption' => 'nullable|string|max:100',
            'link' => 'nullable|url|max:255',
            'order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $imagePath = $instagramPost->image;

        if ($request->hasFile('image')) {
            // Delete old image
            Storage::disk('public')->delete($instagramPost->image);
            // Upload new image
            $imagePath = $request->file('image')->store('instagram', 'public');
        }

        $instagramPost->update([
            'image' => $imagePath,
            'caption' => $request->caption,
            'link' => $request->link,
            'order' => $request->order ?? $instagramPost->order,
            'is_active' => $request->filled('is_active'),
        ]);

        return redirect()->route('admin.instagram-posts.index')
            ->with('success', 'Instagram post updated successfully.');
    }

    public function destroy(InstagramPost $instagramPost)
    {
        // Delete image
        Storage::disk('public')->delete($instagramPost->image);

        $instagramPost->delete();

        return redirect()->route('admin.instagram-posts.index')
            ->with('success', 'Instagram post deleted successfully.');
    }

    public function toggleStatus(InstagramPost $instagramPost)
    {
        $instagramPost->update([
            'is_active' => !$instagramPost->is_active
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.',
            'is_active' => $instagramPost->is_active
        ]);
    }
}
