<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class SkillController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Skills/Index', [
            'skills' => Skill::query()
                ->orderBy('category')
                ->orderBy('sort_order')
                ->get()
                ->map(fn (Skill $skill) => [
                    'id' => $skill->id,
                    'name' => $skill->name,
                    'category' => $skill->category,
                    'proficiency' => $skill->proficiency,
                    'sort_order' => $skill->sort_order,
                    'edit_url' => route('admin.skills.edit', $skill),
                ]),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Skills/Form', [
            'skill' => null,
            'categories' => Skill::CATEGORIES,
            'nextSortOrder' => (int) Skill::max('sort_order') + 1,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate($this->rules());
        if (! isset($data['sort_order'])) {
            $data['sort_order'] = (int) Skill::max('sort_order') + 1;
        }

        Skill::create($data);

        return redirect()->route('admin.skills.index')
            ->with('success', 'Skill added.');
    }

    public function edit(Skill $skill): Response
    {
        return Inertia::render('Admin/Skills/Form', [
            'skill' => [
                'id' => $skill->id,
                'name' => $skill->name,
                'category' => $skill->category,
                'description' => $skill->description,
                'icon' => $skill->icon,
                'proficiency' => $skill->proficiency,
                'sort_order' => $skill->sort_order,
            ],
            'categories' => Skill::CATEGORIES,
            'nextSortOrder' => null,
        ]);
    }

    public function update(Request $request, Skill $skill): RedirectResponse
    {
        $skill->update($request->validate($this->rules()));

        return redirect()->route('admin.skills.index')
            ->with('success', 'Skill updated.');
    }

    public function destroy(Skill $skill): RedirectResponse
    {
        $skill->delete();

        return redirect()->route('admin.skills.index')
            ->with('success', 'Skill removed.');
    }

    private function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'category' => ['required', Rule::in(Skill::CATEGORIES)],
            'description' => ['nullable', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:60'],
            'proficiency' => ['nullable', 'integer', 'between:0,100'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
