# John Lee Calulut — Full-Stack Portfolio

A production-ready, single-page personal portfolio built with **Laravel 12 + Vue 3 + Inertia.js + Tailwind CSS + MySQL**.

Dark orange/black developer theme, fixed expanding sidebar, scroll-spy navigation,
database-driven sections, and a validated contact form that stores messages in MySQL.

Includes a full **admin panel** at `/admin` — secure login, dashboard, and CRUD for
projects, skills, services, timeline entries, education, and contact messages.

## Requirements

- PHP 8.2+ with Composer
- Node.js 18+ with npm
- MySQL 8 (or MariaDB 10.3+)

## Setup

```bash
# 1. Install dependencies
composer install
npm install

# 2. Environment
cp .env.example .env
php artisan key:generate

# 3. Create a MySQL database called `portfolio`
#    (or edit DB_DATABASE / DB_USERNAME / DB_PASSWORD in .env)

# 4. Create tables and seed the portfolio content + admin account
php artisan migrate --seed

# 5. Run it
php artisan serve        # backend  → http://localhost:8000
npm run dev              # Vite dev server (separate terminal)
```

For production: `npm run build`, then serve with your usual Laravel stack.

## Admin panel

Visit **http://localhost:8000/admin**. The seeded login defaults to:

- Email: `admin@johncalulut.dev`
- Password: `password`

Override these before seeding via `ADMIN_NAME`, `ADMIN_EMAIL`, and `ADMIN_PASSWORD`
in `.env` — and **change the password before deploying publicly**.

Manage from the dashboard:

- **Projects** — title, slug, description, thumbnail, tech stack, GitHub / demo URLs, publish toggle, ordering
- **Skills** — name, category (frontend / backend / database / tools), description, icon, proficiency 0–100, ordering
- **Services** — title, description, icon, ordering
- **Timeline** — title, subtitle, description, period, ordering
- **Education** — institution, degree, field of study, location, period, description, ordering
- **Messages** — read/unread inbox from the contact form, with per-message view, reply (mailto), mark all read, and delete

## Architecture

```
Laravel
  routes/web.php            → GET / · GET /home (redirect) · POST /contact (throttled)
  routes/admin.php          → /admin auth + dashboard + CRUD (registered from web.php)
  app/Http/Controllers/Admin → Auth, Dashboard, Project, Skill, Service, TimelineItem, Education, ContactMessage
  app/Http/Middleware       → EnsureAdmin, RedirectIfAdmin (admin.auth / admin.guest aliases)
  Models + migrations       → projects, skills, services, timeline_items, education, contact_messages, admins
  PortfolioController       → loads projects / skills / services / timeline / education from MySQL
  ContactController         → stores validated ContactMessage records
  StoreContactMessageRequest→ sanitization + server-side validation rules

Vue (via Inertia)
  resources/js/Pages/Portfolio.vue
  resources/js/Components/Sections/EducationSection.vue   → DB-driven education cards
  resources/js/Pages/Admin                             → AdminLogin, Dashboard + CRUD screens
  resources/js/Components/Admin                        → AdminLayout (sidebar/topbar), Field helper
  resources/js/Components/                             → Layout, Navigation, UI, Buttons, Cards, Timeline, Forms, Sections
  resources/js/Composables/                            → useScrollSpy, useScrollReveal, useTheme
  resources/js/Data/site.js                            → single source of truth: name, role, nav, socials, contact info
```

## Customizing content

- **Site-wide info** (name, role, navigation, socials, email): `resources/js/Data/site.js`.
  Replace the placeholder GitHub/LinkedIn URLs there with your real profiles.
- **Projects, skills, services, timeline, education**: use the admin panel at `/admin`,
  or edit the rows in `database/seeders/DatabaseSeeder.php` and re-run
  `php artisan migrate:fresh --seed`.
- **Education section**: fully database-driven — add or edit entries at
  `/admin/education` and the public section updates automatically.
- **Contact messages**: stored in the `contact_messages` table and viewable in the admin inbox.

## Security notes

- CSRF protection on every POST (Laravel web middleware + Inertia shares the token).
- All contact input is sanitized and validated server-side; nothing is mass-assignable
  outside each model's `$fillable` list.
- The contact endpoint is rate-limited to 5 submissions per minute per IP; the admin
  login is throttled as well.
- Admin routes require authentication via a dedicated session guard.
- No secrets in the repo — everything sensitive lives in `.env`.
