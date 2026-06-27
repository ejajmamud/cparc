# Chittagong Port Republic Club – Laravel Website Plan

## 1. Project‑wide Setup

1. **Install required tools** – PHP (via XAMPP), Composer, Laravel Installer, **herd**.
2. **Create Laravel app** directly in `D:\Projects\cparc`:
   ```bash
   cd D:\Projects\cparc
   composer create-project laravel/laravel .
   ```
3. **Configure `.env`** for local XAMPP MySQL and set `APP_URL`.
4. **Add herd support** – create `herd.json` with:
   ```json
   { "root": "public", "port": 8000 }
   ```
5. **Initial commit** to a git repo.

## 2. Choose Base Visual Template

We have two source theme folders:
- `D:\Projects\Clone\Scouts\scouts.gov.bd`
- `D:\Projects\Clone\Govt\webbazarbd.top\sorkaritheme`

> **Decision needed** – use one as the primary layout or merge both.

## 3. Asset Extraction & Placement

| Source | Destination (Laravel) | Action |
|--------|-----------------------|--------|
| `*.html` (pages) | `resources/views/` | Convert each to a Blade file (`*.blade.php`). |
| `css/` | `public/css/` (or `resources/css/` if using Vite/Mix) | Preserve hierarchy; update paths. |
| `js/` | `public/js/` (or `resources/js/`) | Same as CSS. |
| Images, fonts, icons | `public/assets/` | Keep original sub‑folders. |
| Reusable parts (header, footer, nav) | `resources/views/partials/` | Split into partial Blade files (`header.blade.php`, …). |
| Any PHP snippets inside HTML | Directly embed in Blade | Enables immediate Laravel integration. |

## 4. Convert HTML → Blade

1. **Master layout** – `resources/views/layouts/app.blade.php` with `<head>` links, `@stack('styles')`, and `@yield('content')`.
2. **Partials** – `partials/header.blade.php`, `partials/footer.blade.php`, `partials/nav.blade.php` and include via `@include`.
3. **Each page**:
   - Strip duplicate `<html>`, `<head>`, `<body>` tags.
   - Wrap body in `@section('content') … @endsection`.
   - Replace static URLs with Laravel helpers: `{{ asset('css/style.css') }}`, `{{ url('/') }}`.
4. **Routing** – add simple view routes in `routes/web.php` e.g. `Route::view('/about', 'about');`.

## 5. Dynamic Data Layer (optional but recommended)

| Entity | Migration | Model | Controller | Route |
|--------|-----------|-------|------------|-------|
| Members/Board | `php artisan make:migration create_members_table` | `Member` | `MemberController` | `Route::resource('members', MemberController::class);` |
| Events | `create_events_table` | `Event` | `EventController` | `Route::resource('events', EventController::class);` |
| News/Blog | `create_posts_table` | `Post` | `PostController` | `Route::resource('news', PostController::class);` |
| Contact form | `contacts` table | `Contact` | `ContactController@store` | `POST /contact` |

> If a purely static site is sufficient, skip this section.

## 6. Asset Pipeline (Vite – default in Laravel 10)

1. Move CSS/JS into `resources/` if you want bundling.
2. Update `vite.config.js` to include any third‑party libraries.
3. Run `npm install` then `npm run dev` (or `npm run build` for production).

*If you prefer Laravel Mix, replace Vite with a `webpack.mix.js` configuration.*

## 7. Local Serving with **herd**

1. Run `herd serve` inside `D:\Projects\cparc`.
2. Site becomes available at `http://localhost:8000`.
3. XAMPP continues to host MySQL; herd serves the Laravel `public/` folder.

## 8. Testing & Quality Checks

- **Blade syntax**: `php artisan view:cache`.
- **Asset loading**: Verify CSS/JS in browser dev tools.
- **Database**: `php artisan migrate` and inspect via phpMyAdmin.
- **CSRF**: Ensure all forms contain `@csrf`.
- **Responsive**: Test across device widths (templates already responsive).
- **Version control**: Initialise Git and commit after each major milestone.

## 9. Optional Enhancements

- **Authentication** – `composer require laravel/breeze --dev` → `php artisan breeze:install`.
- **Admin panel** – Laravel Nova or Filament for content management.
- **SEO** – Blade component for dynamic meta tags.

---

## Research on Chittagong Port Republic Club

*Due to limited public data, the following placeholder text is used. Replace with real content when available.*

> **[Placeholder]** The **Chittagong Port Republic Club** is a community organization based in the Chittagong Port area. It focuses on maritime heritage, local commerce, and cultural events. The club hosts annual festivals, offers training for seafarers, and maintains a museum of historic vessels. Its mission is to promote economic development and preserve the maritime legacy of the region.

> **[Placeholder]** Key activities include:
> - **Maritime education** programs for youth.
> - **Cultural exhibitions** showcasing the port’s history.
> - **Networking events** for local businesses and shipping companies.
> - **Community outreach** through health camps and environmental clean‑up drives.

> **[Placeholder]** The club’s official website (if any) provides sections for **About Us**, **Events**, **Membership**, **Gallery**, and **Contact**. These sections map directly to the Blade views we will create.

> **[Placeholder]** *Insert actual text, mission statement, and any available statistics once the club’s official resources are reviewed.*

---

### Next Action
1. Please confirm which template folder to use as the primary source (or if we should merge both).
2. Approve the plan so I can start scaffolding the Laravel project, copy assets, and generate the first Blade view.

*Once approved, I will begin populating the repository and committing each step.*
