<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\Project;
use App\Models\Service;
use App\Models\Skill;
use App\Models\TimelineItem;
use Inertia\Inertia;
use Inertia\Response;

class PortfolioController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Portfolio', [
            'projects' => Project::query()
                ->where('is_published', true)
                ->orderBy('sort_order')
                ->get(),

            // Grouped by category: ['frontend' => [...], 'backend' => [...], ...]
            'skills' => Skill::query()
                ->orderBy('sort_order')
                ->get()
                ->groupBy('category'),

            'services' => Service::query()
                ->orderBy('sort_order')
                ->get(),

            'timeline' => TimelineItem::query()
                ->orderBy('sort_order')
                ->get(),

            'education' => Education::query()
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get(),
        ]);
    }
}
