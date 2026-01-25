<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::first();
        return view('backend.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'about_text' => 'nullable|string',
            'site_email' => 'required|email|max:255',
            'site_phone' => 'required|string|max:20',
            'site_address' => 'required|string',
            'google_map_url' => 'nullable|string',
            'delivery_charge' => 'required|numeric|min:0',
            'facebook_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'pinterest_url' => 'nullable|url',
            'youtube_url' => 'nullable|url',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'favicon' => 'nullable|image|mimes:ico,png|max:1024',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
        ]);

        $settings = Setting::first();

        if (!$settings) {
            $settings = new Setting();
        }

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo
            if ($settings->logo) {
                Storage::disk('public')->delete($settings->logo);
            }
            $logoPath = $request->file('logo')->store('settings', 'public');
            $settings->logo = $logoPath;
        }

        // Handle favicon upload
        if ($request->hasFile('favicon')) {
            // Delete old favicon
            if ($settings->favicon) {
                Storage::disk('public')->delete($settings->favicon);
            }
            $faviconPath = $request->file('favicon')->store('settings', 'public');
            $settings->favicon = $faviconPath;
        }

        $settings->site_name = $request->site_name;
        $settings->about_text = $request->about_text;
        $settings->site_email = $request->site_email;
        $settings->site_phone = $request->site_phone;
        $settings->site_address = $request->site_address;
        $settings->google_map_url = $request->google_map_url;
        $settings->delivery_charge = $request->delivery_charge;
        $settings->facebook_url = $request->facebook_url;
        $settings->twitter_url = $request->twitter_url;
        $settings->instagram_url = $request->instagram_url;
        $settings->pinterest_url = $request->pinterest_url;
        $settings->youtube_url = $request->youtube_url;
        $settings->meta_title = $request->meta_title;
        $settings->meta_description = $request->meta_description;
        $settings->meta_keywords = $request->meta_keywords;

        $settings->save();

        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings updated successfully.');
    }
}
