<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TimelineItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TimelineItemController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/TimelineItems/Index', [
            'timelineItems' => TimelineItem::query()
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get()
                ->map(fn (TimelineItem $item) => [
                    'id' => $item->id,
                    'title' => $item->title,
                    'subtitle' => $item->subtitle,
                    'period' => $item->period,
                    'sort_order' => $item->sort_order,
                    'edit_url' => route('admin.timeline-items.edit', $item),
                ]),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/TimelineItems/Form', [
            'timelineItem' => null,
            'nextSortOrder' => (int) TimelineItem::max('sort_order') + 1,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'period' => ['nullable', 'string', 'max:120'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);
        if (! isset($data['sort_order'])) {
            $data['sort_order'] = (int) TimelineItem::max('sort_order') + 1;
        }

        TimelineItem::create($data);

        return redirect()->route('admin.timeline-items.index')
            ->with('success', 'Timeline entry added.');
    }

    public function edit(TimelineItem $timelineItem): Response
    {
        return Inertia::render('Admin/TimelineItems/Form', [
            'timelineItem' => [
                'id' => $timelineItem->id,
                'title' => $timelineItem->title,
                'subtitle' => $timelineItem->subtitle,
                'description' => $timelineItem->description,
                'period' => $timelineItem->period,
                'sort_order' => $timelineItem->sort_order,
            ],
            'nextSortOrder' => null,
        ]);
    }

    public function update(Request $request, TimelineItem $timelineItem): RedirectResponse
    {
        $timelineItem->update($request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'period' => ['nullable', 'string', 'max:120'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]));

        return redirect()->route('admin.timeline-items.index')
            ->with('success', 'Timeline entry updated.');
    }

    public function destroy(TimelineItem $timelineItem): RedirectResponse
    {
        $timelineItem->delete();

        return redirect()->route('admin.timeline-items.index')
            ->with('success', 'Timeline entry removed.');
    }
}
