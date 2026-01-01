<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\DiscountBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DiscountBannerController extends Controller
{
    public function index()
    {
        $banners = DiscountBanner::latest()->paginate(10);
        return view('backend.discount_banners.index', compact('banners'));
    }

    public function create()
    {
        return view('backend.discount_banners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:100',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'discount_percentage' => 'required|numeric|min:1|max:99',
            'discount_code' => 'nullable|string|max:50',
            'end_date' => 'nullable|date',
            'is_active' => 'boolean',
        ]);

        $imagePath = $request->file('image')->store('discount-banners', 'public');

        DiscountBanner::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'image' => $imagePath,
            'discount_percentage' => $request->discount_percentage,
            'discount_code' => $request->discount_code,
            'end_date' => $request->end_date,
            'is_active' => $request->filled('is_active'),
        ]);

        return redirect()->route('admin.discount-banners.index')
            ->with('success', 'Discount banner created.');
    }


    public function edit(DiscountBanner $discountBanner)
    {
        return view('backend.discount_banners.edit', compact('discountBanner'));
    }

    public function update(Request $request, DiscountBanner $discountBanner)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'discount_percentage' => 'required|numeric|min:1|max:99',
            'discount_code' => 'nullable|string|max:50',
            'end_date' => 'nullable|date',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($discountBanner->image);
            $imagePath = $request->file('image')->store('discount-banners', 'public');
            $discountBanner->image = $imagePath;
        }

        $discountBanner->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'discount_percentage' => $request->discount_percentage,
            'discount_code' => $request->discount_code,
            'end_date' => $request->end_date,
            'is_active' => $request->filled('is_active'),
        ]);

        return redirect()->route('admin.discount-banners.index')
            ->with('success', 'Discount banner updated.');
    }

    public function destroy(DiscountBanner $discountBanner)
    {
        if ($discountBanner->image) {
            Storage::disk('public')->delete($discountBanner->image);
        }

        $discountBanner->delete();

        return redirect()->route('admin.discount-banners.index')
            ->with('success', 'Discount banner deleted successfully.');
    }

    public function toggleStatus(DiscountBanner $discountBanner)
    {
        $discountBanner->update([
            'is_active' => !$discountBanner->is_active
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.',
            'is_active' => $discountBanner->is_active
        ]);
    }
}
