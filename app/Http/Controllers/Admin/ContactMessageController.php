<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ContactMessageController extends Controller
{
    public function index(Request $request): Response
    {
        $messages = ContactMessage::query()
            ->when($request->boolean('unread'), fn ($q) => $q->where('is_read', false))
            ->latest()
            ->paginate(12)
            ->withQueryString()
            ->through(fn (ContactMessage $message) => [
                'id' => $message->id,
                'name' => $message->name,
                'email' => $message->email,
                'subject' => $message->subject,
                'is_read' => $message->is_read,
                'created_at' => $message->created_at?->diffForHumans(),
                'show_url' => route('admin.contact-messages.show', $message),
            ]);

        return Inertia::render('Admin/ContactMessages/Index', [
            'messages' => $messages->items(),
            'pagination' => [
                'total' => $messages->total(),
                'per_page' => $messages->perPage(),
                'current_page' => $messages->currentPage(),
                'last_page' => $messages->lastPage(),
                'links' => $messages->linkCollection()->prepend($messages->previousPageUrl()?->then(fn () => null) ?? null)->all(),
            ],
            'unreadFilter' => $request->boolean('unread'),
            'unreadCount' => ContactMessage::where('is_read', false)->count(),
        ]);
    }

    public function show(ContactMessage $contactMessage): Response
    {
        if (! $contactMessage->is_read) {
            $contactMessage->update(['is_read' => true]);
        }

        return Inertia::render('Admin/ContactMessages/Show', [
            'message' => [
                'id' => $contactMessage->id,
                'name' => $contactMessage->name,
                'email' => $contactMessage->email,
                'subject' => $contactMessage->subject,
                'message' => $contactMessage->message,
                'is_read' => true,
                'created_at' => $contactMessage->created_at?->format('M j, Y g:i A'),
            ],
        ]);
    }

    public function toggleRead(ContactMessage $contactMessage): RedirectResponse
    {
        $contactMessage->update(['is_read' => ! $contactMessage->is_read]);

        return back()->with('success', $contactMessage->is_read ? 'Marked as read.' : 'Marked as unread.');
    }

    public function markAllRead(): RedirectResponse
    {
        ContactMessage::where('is_read', false)->update(['is_read' => true]);

        return back()->with('success', 'All messages marked as read.');
    }

    public function destroy(ContactMessage $contactMessage): RedirectResponse
    {
        $contactMessage->delete();

        return redirect()->route('admin.contact-messages.index')
            ->with('success', 'Message deleted.');
    }
}
