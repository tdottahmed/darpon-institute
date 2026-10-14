<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\MetaConversionsApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * Handle contact form submission.
     */
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
            'pixel_event_id' => 'nullable|string|max:64',
        ]);

        if (! empty($validated['pixel_event_id'])) {
            MetaConversionsApi::track('Contact', $validated['pixel_event_id'], $validated, [], $request);
        }

        // Here you can:
        // 1. Send email notification
        // 2. Store in database
        // 3. Send to admin email

        // For now, we'll just return success
        // You can implement email sending later

        return back()->with('success', 'Thank you for your message! We will get back to you soon.');
    }
}
