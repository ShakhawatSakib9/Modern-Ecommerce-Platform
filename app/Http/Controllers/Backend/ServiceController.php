<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::latest()->paginate(10);
        return view('backend.services.index', compact('services'));
    }

    public function create()
    {
        $icons = [
            'fa fa-car',
            'fa fa-money',
            'fa fa-support',
            'fa fa-headphones',
            'fa fa-truck',
            'fa fa-shield',
            'fa fa-undo',
            'fa fa-gift',
            'fa fa-credit-card',
            'fa fa-clock',
            'fa fa-star',
            'fa fa-tag',
            'fa fa-lock',
            'fa fa-globe',
            'fa fa-heart',
        ];

        // Get next order number
        $nextOrder = (Service::max('order') ?? 0) + 1;

        return view('backend.services.create', compact('icons', 'nextOrder'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'icon' => 'required|string|max:50',
            'title' => 'required|string|max:100',
            'description' => 'required|string|max:255',
            'is_active' => 'boolean',
            'order' => 'integer|min:0',
        ]);

        // Auto-increment order if 0 or empty
        $order = $request->order;
        if ($order == 0 || empty($order)) {
            $lastOrder = Service::max('order') ?? 0;
            $order = $lastOrder + 1;
        }

        Service::create([
            'icon' => $request->icon,
            'title' => $request->title,
            'description' => $request->description,
            'is_active' => $request->filled('is_active'),
            'order' => $order,
        ]);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service created successfully.');
    }

    public function edit(Service $service)
    {
        $icons = [
            'fa fa-car',
            'fa fa-money',
            'fa fa-support',
            'fa fa-headphones',
            'fa fa-truck',
            'fa fa-shield',
            'fa fa-undo',
            'fa fa-gift',
            'fa fa-credit-card',
            'fa fa-clock',
            'fa fa-star',
            'fa fa-tag',
            'fa fa-lock',
            'fa fa-globe',
            'fa fa-heart',
        ];

        return view('backend.services.edit', compact('service', 'icons'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'icon' => 'required|string|max:50',
            'title' => 'required|string|max:100',
            'description' => 'required|string|max:255',
            'is_active' => 'boolean',
            'order' => 'integer|min:0',
        ]);

        $service->update([
            'icon' => $request->icon,
            'title' => $request->title,
            'description' => $request->description,
            'is_active' => $request->filled('is_active'),
            'order' => $request->order ?? $service->order,
        ]);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('admin.services.index')
            ->with('success', 'Service deleted successfully.');
    }

    public function toggleStatus(Service $service)
    {
        $service->update([
            'is_active' => !$service->is_active
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.',
            'is_active' => $service->is_active
        ]);
    }
}
