<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Education;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class EducationController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Education/Index', [
            'education' => Education::query()
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get()
                ->map(fn (Education $item) => [
                    'id' => $item->id,
                    'institution' => $item->institution,
                    'degree' => $item->degree,
                    'field_of_study' => $item->field_of_study,
                    'period' => $item->period,
                    'sort_order' => $item->sort_order,
                    'edit_url' => route('admin.education.edit', $item),
                ]),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Education/Form', [
            'education' => null,
            'nextSortOrder' => (int) Education::max('sort_order') + 1,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'institution' => ['required', 'string', 'max:255'],
            'degree' => ['required', 'string', 'max:255'],
            'field_of_study' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'period' => ['nullable', 'string', 'max:120'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);
        if (! isset($data['sort_order'])) {
            $data['sort_order'] = (int) Education::max('sort_order') + 1;
        }

        Education::create($data);

        return redirect()->route('admin.education.index')
            ->with('success', 'Education entry added.');
    }

    public function edit(Education $education): Response
    {
        return Inertia::render('Admin/Education/Form', [
            'education' => [
                'id' => $education->id,
                'institution' => $education->institution,
                'degree' => $education->degree,
                'field_of_study' => $education->field_of_study,
                'location' => $education->location,
                'description' => $education->description,
                'period' => $education->period,
                'sort_order' => $education->sort_order,
            ],
            'nextSortOrder' => null,
        ]);
    }

    public function update(Request $request, Education $education): RedirectResponse
    {
        $education->update($request->validate([
            'institution' => ['required', 'string', 'max:255'],
            'degree' => ['required', 'string', 'max:255'],
            'field_of_study' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'period' => ['nullable', 'string', 'max:120'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]));

        return redirect()->route('admin.education.index')
            ->with('success', 'Education entry updated.');
    }

    public function destroy(Education $education): RedirectResponse
    {
        $education->delete();

        return redirect()->route('admin.education.index')
            ->with('success', 'Education entry removed.');
    }
}
