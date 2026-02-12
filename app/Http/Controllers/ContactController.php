<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000'
        ]);

        // Add timestamp
        $validated['submitted_at'] = now()->format('F j, Y g:i A');

        // List of recipients (can be configured in .env later)
        $recipients = [
            'coreysmaller@gmail.com'
        ];

        try {
            // Send email to all recipients
            foreach ($recipients as $recipient) {
                Mail::to($recipient)->send(new ContactFormMail($validated));
            }

            return response()->json([
                'message' => 'Thank you for contacting us! We will get back to you soon.',
                'success' => true
            ], 200);

        } catch (\Exception $e) {
            \Log::error('Contact form email failed: ' . $e->getMessage());
            
            return response()->json([
                'message' => 'There was an error sending your message. Please try again later.',
                'success' => false
            ], 500);
        }
    }
}
