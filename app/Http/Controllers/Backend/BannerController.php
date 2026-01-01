<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('order')->latest()->paginate(10);
        return view('backend.banners.index', compact('banners'));
    }

    public function create()
    {
        // Get the next order number
        $lastOrder = Banner::max('order');
        $nextOrder = $lastOrder + 1;

        return view('backend.banners.create', compact('nextOrder'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'button_text' => 'nullable|string|max:50',
            'button_link' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'status' => 'required|in:active,inactive'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('banners', 'public');
        }

        // Calculate order if not provided
        $order = $request->order;
        if (empty($order)) {
            $lastOrder = Banner::max('order');
            $order = $lastOrder + 1;
        }

        Banner::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'image' => $imagePath,
            'button_text' => $request->button_text ?? 'Shop Now',
            'button_link' => $request->button_link ?? '/shop',
            'order' => $order,
            'status' => $request->status
        ]);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner created successfully.');
    }

    public function show(Banner $banner)
    {
        return view('backend.banners.show', compact('banner'));
    }

    public function edit(Banner $banner)
    {
        return view('backend.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'button_text' => 'nullable|string|max:50',
            'button_link' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'status' => 'required|in:active,inactive'
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($banner->image) {
                Storage::disk('public')->delete($banner->image);
            }
            // Store new image
            $imagePath = $request->file('image')->store('banners', 'public');
            $banner->image = $imagePath;
        }

        $banner->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'button_text' => $request->button_text ?? 'Shop Now',
            'button_link' => $request->button_link ?? '/shop',
            'order' => $request->order ?? $banner->order,
            'status' => $request->status
        ]);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner updated successfully.');
    }

    public function destroy(Banner $banner)
    {
        // Delete image from storage
        if ($banner->image) {
            Storage::disk('public')->delete($banner->image);
        }

        $banner->delete();

        // Reorder remaining banners
        $this->reorderBanners();

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner deleted successfully.');
    }

    public function toggleStatus(Banner $banner)
    {
        $banner->update([
            'status' => $banner->status === 'active' ? 'inactive' : 'active'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.',
            'status' => $banner->status
        ]);
    }

    /**
     * Reorder banners after deletion
     */
    private function reorderBanners()
    {
        $banners = Banner::orderBy('order')->get();
        $order = 1;
        foreach ($banners as $banner) {
            $banner->update(['order' => $order]);
            $order++;
        }
    }

    /**
     * Update order via AJAX (for drag & drop sorting)
     */
    public function updateOrder(Request $request)
    {
        foreach ($request->order as $orderData) {
            Banner::where('id', $orderData['id'])->update(['order' => $orderData['position']]);
        }

        return response()->json(['success' => true]);
    }
}
