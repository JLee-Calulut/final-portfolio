<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ServiceController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Services/Index', [
            'services' => Service::query()
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get()
                ->map(fn (Service $service) => [
                    'id' => $service->id,
                    'title' => $service->title,
                    'icon' => $service->icon,
                    'sort_order' => $service->sort_order,
                    'edit_url' => route('admin.services.edit', $service),
                ]),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Services/Form', [
            'service' => null,
            'nextSortOrder' => (int) Service::max('sort_order') + 1,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:500'],
            'icon' => ['nullable', 'string', 'max:60'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);
        if (! isset($data['sort_order'])) {
            $data['sort_order'] = (int) Service::max('sort_order') + 1;
        }

        Service::create($data);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service added.');
    }

    public function edit(Service $service): Response
    {
        return Inertia::render('Admin/Services/Form', [
            'service' => [
                'id' => $service->id,
                'title' => $service->title,
                'description' => $service->description,
                'icon' => $service->icon,
                'sort_order' => $service->sort_order,
            ],
            'nextSortOrder' => null,
        ]);
    }

    public function update(Request $request, Service $service): RedirectResponse
    {
        $service->update($request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:500'],
            'icon' => ['nullable', 'string', 'max:60'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]));

        return redirect()->route('admin.services.index')
            ->with('success', 'Service updated.');
    }

    public function destroy(Service $service): RedirectResponse
    {
        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'Service removed.');
    }
}
