<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        $settings = \App\Models\Backend\Setting::first();
        return view('frontend.contact', compact('settings'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Get site email from settings
        $settings = \App\Models\Backend\Setting::first();
        $site_email = $settings->site_email ?? 'info@clothingstore.com';

        // Prepare email data
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message_content' => $request->message,
            'site_name' => $settings->site_name ?? 'Clothing Store',
        ];

        try {
            // Send email
            Mail::send('emails.contact', $data, function($message) use ($site_email, $request) {
                $message->to($site_email)
                        ->subject('Contact Form: ' . $request->subject)
                        ->replyTo($request->email);
            });

            return redirect()->route('contact')->with('success', 'Your message has been sent successfully! We will get back to you soon.');
        } catch (\Exception $e) {
            // If email fails, still show success but log error
            \Log::error('Contact form email failed: ' . $e->getMessage());
            return redirect()->route('contact')->with('success', 'Your message has been received! We will get back to you soon.');
        }
    }
}
