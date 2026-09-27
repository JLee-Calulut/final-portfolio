<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactMessageRequest;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Throwable;

class ContactController extends Controller
{
    public function store(StoreContactMessageRequest $request): RedirectResponse
    {
        try {
            ContactMessage::create(
                $request->safe()->only(['name', 'email', 'subject', 'message'])
            );
        } catch (Throwable $exception) {
            Log::error('Failed to store contact message', [
                'exception' => $exception->getMessage(),
            ]);

            return back()->withErrors([
                'message' => 'Something went wrong while sending your message. Please try again in a moment.',
            ]);
        }

        return back()->with('success', "Thanks for reaching out — I'll get back to you soon.");
    }
}
