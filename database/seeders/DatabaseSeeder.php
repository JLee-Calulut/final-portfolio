<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Education;
use App\Models\Project;
use App\Models\Service;
use App\Models\Skill;
use App\Models\TimelineItem;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the portfolio with its initial content so the site works
     * immediately after `php artisan migrate --seed`, and create the
     * default admin account used to log into /admin.
     *
     * Placeholder URLs are intentionally null — never ship fake links.
     */
    public function run(): void
    {
        $this->seedAdmin();
        $this->seedSkills();
        $this->seedServices();
        $this->seedProjects();
        $this->seedTimeline();
        $this->seedEducation();
    }

    /**
     * Default admin account. Configure via ADMIN_EMAIL / ADMIN_NAME /
     * ADMIN_PASSWORD in .env; falls back to safe local defaults.
     */
    private function seedAdmin(): void
    {
        Admin::query()->firstOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@johncalulut.dev')],
            [
                'name' => env('ADMIN_NAME', 'John Lee Calulut'),
                'password' => env('ADMIN_PASSWORD', 'password'),
            ],
        );
    }

    private function seedSkills(): void
    {
        $skills = [
            // Frontend
            ['name' => 'Vue.js',       'category' => 'frontend', 'description' => 'Reactive interfaces with the Composition API.', 'icon' => 'vue',        'proficiency' => 85],
            ['name' => 'JavaScript',   'category' => 'frontend', 'description' => 'Modern ES6+ and browser APIs.',                 'icon' => 'javascript', 'proficiency' => 80],
            ['name' => 'HTML',         'category' => 'frontend', 'description' => 'Semantic, accessible markup.',                  'icon' => 'html',       'proficiency' => 90],
            ['name' => 'CSS',          'category' => 'frontend', 'description' => 'Layouts, animations, responsive design.',       'icon' => 'css',        'proficiency' => 85],
            ['name' => 'Tailwind CSS', 'category' => 'frontend', 'description' => 'Utility-first styling and design systems.',     'icon' => 'tailwind',   'proficiency' => 85],

            // Backend
            ['name' => 'Laravel',      'category' => 'backend',  'description' => 'MVC apps, Eloquent, queues, validation.',       'icon' => 'laravel',    'proficiency' => 80],
            ['name' => 'PHP',          'category' => 'backend',  'description' => 'Modern PHP 8 for web backends.',                'icon' => 'php',        'proficiency' => 75],
            ['name' => 'REST APIs',    'category' => 'backend',  'description' => 'Clean, versioned API design and auth.',         'icon' => 'api',        'proficiency' => 80],

            // Database
            ['name' => 'MySQL',        'category' => 'database', 'description' => 'Schema design, indexes, and query tuning.',     'icon' => 'database',   'proficiency' => 70],

            // Tools
            ['name' => 'Git',          'category' => 'tools',    'description' => 'Branching, reviews, clean history.',            'icon' => 'git',        'proficiency' => 80],
            ['name' => 'GitHub',       'category' => 'tools',    'description' => 'Collaboration, issues, CI workflows.',          'icon' => 'github',     'proficiency' => 80],
            ['name' => 'Vite',         'category' => 'tools',    'description' => 'Fast builds and hot module reload.',            'icon' => 'vite',       'proficiency' => 70],
            ['name' => 'VS Code',      'category' => 'tools',    'description' => 'Daily editor, debugging, extensions.',          'icon' => 'vscode',     'proficiency' => 85],
        ];

        foreach ($skills as $index => $skill) {
            Skill::create([...$skill, 'sort_order' => $index]);
        }
    }

    private function seedServices(): void
    {
        $services = [
            ['title' => 'Frontend Development',      'description' => 'Modern, responsive and interactive interfaces with Vue and Tailwind CSS.',  'icon' => 'monitor'],
            ['title' => 'Backend Development',       'description' => 'Laravel-powered APIs and backend systems with clean architecture.',         'icon' => 'server'],
            ['title' => 'Full-Stack Development',    'description' => 'Complete web applications using Laravel and Vue, end to end.',              'icon' => 'layers'],
            ['title' => 'UI Component Development',  'description' => 'Reusable and maintainable UI components your team can build on.',           'icon' => 'components'],
            ['title' => 'Responsive Web Design',     'description' => 'Interfaces optimized for desktop, tablet and mobile.',                      'icon' => 'devices'],
        ];

        foreach ($services as $index => $service) {
            Service::create([...$service, 'sort_order' => $index]);
        }
    }

    private function seedProjects(): void
    {
        $projects = [
            [
                'title' => 'UI Component Library',
                'slug' => 'ui-component-library',
                'description' => 'A reusable UI component library built with Vue and Tailwind.',
                'thumbnail' => null,
                'tech_stack' => ['Vue.js', 'Tailwind CSS', 'JavaScript', 'Vite'],
                'github_url' => null, // Placeholder — add your repository URL when available.
                'demo_url' => null,   // Placeholder — add a live demo URL when available.
            ],
            [
                'title' => 'Task Management App',
                'slug' => 'task-management-app',
                'description' => 'A full-stack task management application designed to manage tasks, projects, and productivity workflows.',
                'thumbnail' => null,
                'tech_stack' => ['Laravel', 'Vue.js', 'Inertia', 'MySQL', 'Tailwind CSS'],
                'github_url' => null,
                'demo_url' => null,
            ],
            [
                'title' => 'Calculator',
                'slug' => 'calculator',
                'description' => 'A keyboard-friendly calculator built with Vue 3 and Tailwind CSS — chained operations, a rolling history, and floating-point-safe arithmetic. Runs right here on the site.',
                'thumbnail' => '/images/projects/calculator-thumbnail.png',
                'tech_stack' => ['Vue.js', 'Tailwind CSS', 'JavaScript', 'Vite'],
                'github_url' => null,
                'demo_url' => '/calculator', // Internal: opens the in-app calculator page.
            ],
            [
                'title' => 'Todo List',
                'slug' => 'todo-list',
                'description' => 'A keyboard-friendly task manager built with Vue 3 and Tailwind CSS — add, complete, edit, and filter tasks with browser-local persistence. Runs right here on the site.',
                'thumbnail' => '/images/projects/todo-thumbnail.png',
                'tech_stack' => ['Vue.js', 'Tailwind CSS', 'JavaScript'],
                'github_url' => null,
                'demo_url' => '/todo', // Internal: opens the in-app todo list page.
            ],
        ];

        foreach ($projects as $index => $project) {
            Project::create([...$project, 'sort_order' => $index]);
        }
    }

    private function seedTimeline(): void
    {
        // A "Development Journey" timeline — no invented employers or titles.
        // Replace with real experience entries whenever you're ready.
        $items = [
            [
                'title' => 'Learning Web Development',
                'subtitle' => 'Foundations',
                'description' => 'HTML, CSS, and JavaScript fundamentals — building a strong base in how the web actually works.',
                'period' => null,
            ],
            [
                'title' => 'Laravel Development',
                'subtitle' => 'Backend',
                'description' => 'MVC architecture, Eloquent ORM, routing, validation, and building server-side features with PHP.',
                'period' => null,
            ],
            [
                'title' => 'Vue Development',
                'subtitle' => 'Frontend',
                'description' => 'Component-driven interfaces, reactivity, and the Composition API for maintainable frontends.',
                'period' => null,
            ],
            [
                'title' => 'Full-Stack Projects',
                'subtitle' => 'Integration',
                'description' => 'Connecting Laravel backends with Vue frontends through Inertia — complete applications, end to end.',
                'period' => null,
            ],
            [
                'title' => 'Reusable UI Component Development',
                'subtitle' => 'Design systems',
                'description' => 'Designing and building component libraries that keep interfaces consistent and teams fast.',
                'period' => null,
            ],
        ];

        foreach ($items as $index => $item) {
            TimelineItem::create([...$item, 'sort_order' => $index]);
        }
    }

    private function seedEducation(): void
    {
        // Education history — replace with real entries via the admin panel
        // at /admin/education. The section renders from the database.
        $entries = [
            [
                'institution' => 'University of the Philippines',
                'degree' => 'Bachelor of Science',
                'field_of_study' => 'Computer Science',
                'location' => 'Quezon City, Philippines',
                'description' => 'Core coursework in data structures, algorithms, software engineering, and database systems.',
                'period' => '2019 — 2023',
            ],
            [
                'institution' => 'Online & Bootcamp Learning',
                'degree' => 'Specialized Training',
                'field_of_study' => 'Web Development (Laravel + Vue)',
                'location' => 'Remote',
                'description' => 'Focused full-stack training covering Laravel, Vue.js, Inertia, and modern deployment workflows.',
                'period' => '2023 — 2024',
            ],
        ];

        foreach ($entries as $index => $entry) {
            Education::create([...$entry, 'sort_order' => $index]);
        }
    }
}
