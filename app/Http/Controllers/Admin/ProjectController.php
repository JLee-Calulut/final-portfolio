<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class ProjectController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Projects/Index', [
            'projects' => Project::query()
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get()
                ->map(fn (Project $project) => [
                    'id' => $project->id,
                    'title' => $project->title,
                    'slug' => $project->slug,
                    'is_published' => $project->is_published,
                    'sort_order' => $project->sort_order,
                    'tech_stack' => $project->tech_stack ?? [],
                    'edit_url' => route('admin.projects.edit', $project),
                ]),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Projects/Form', [
            'project' => null,
            'nextSortOrder' => (int) Project::max('sort_order') + 1,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['slug'] ?? '', $data['title']);
        if (! isset($data['sort_order'])) {
            $data['sort_order'] = (int) Project::max('sort_order') + 1;
        }

        Project::create($data);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project created.');
    }

    public function edit(Project $project): Response
    {
        return Inertia::render('Admin/Projects/Form', [
            'project' => [
                'id' => $project->id,
                'title' => $project->title,
                'slug' => $project->slug,
                'description' => $project->description,
                'thumbnail' => $project->thumbnail,
                'tech_stack' => $project->tech_stack ?? [],
                'github_url' => $project->github_url,
                'demo_url' => $project->demo_url,
                'sort_order' => $project->sort_order,
                'is_published' => $project->is_published,
            ],
            'nextSortOrder' => null,
        ]);
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['slug'] ?? '', $data['title'], $project->id);

        $project->update($data);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project updated.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $project->delete();

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'thumbnail' => ['nullable', 'max:500', 'regex:/^(https?:\/\/|\/)/'],
            'tech_stack' => ['nullable', 'array'],
            'tech_stack.*' => ['string', 'max:100'],
            'github_url' => ['nullable', 'url', 'max:500'],
            'demo_url' => ['nullable', 'max:500', 'regex:/^(https?:\/\/|\/)/'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_published' => ['sometimes', 'boolean'],
        ]) + ['is_published' => $request->boolean('is_published')];
    }

    private function uniqueSlug(string $slug, string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($slug !== '' ? $slug : $title);
        $candidate = $base;
        $i = 2;

        while (Project::where('slug', $candidate)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $candidate = $base.'-'.$i++;
        }

        return $candidate;
    }
}
