<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Education;
use App\Models\Project;
use App\Models\Service;
use App\Models\Skill;
use App\Models\TimelineItem;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * Admin overview: content counts + latest activity.
     */
    public function index(): Response
    {
        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'projects' => Project::count(),
                'skills' => Skill::count(),
                'services' => Service::count(),
                'timeline' => TimelineItem::count(),
                'education' => Education::count(),
                'messages' => ContactMessage::count(),
                'unreadMessages' => ContactMessage::where('is_read', false)->count(),
            ],
            'recentMessages' => ContactMessage::query()
                ->latest()
                ->limit(5)
                ->get()
                ->map(fn (ContactMessage $message) => [
                    'id' => $message->id,
                    'name' => $message->name,
                    'subject' => $message->subject,
                    'is_read' => $message->is_read,
                    'created_at' => $message->created_at?->diffForHumans(),
                    'show_url' => route('admin.contact-messages.show', $message),
                ]),
        ]);
    }
}
