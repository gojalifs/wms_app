# Copilot Instructions – WMS (Warehouse Management System)

## Project Overview
Laravel 12 application (PHP 8.2+) for warehouse management. Frontend uses Vite + Tailwind CSS v4. Currently in early/scaffolding stage — controllers, models, and routes are yet to be built out.

## Stack
- **Backend:** Laravel 12, PHP 8.2+, Eloquent ORM
- **Frontend:** Blade templates, Tailwind CSS v4 (via `@tailwindcss/vite`), Axios
- **Testing:** PHPUnit 11, SQLite in-memory for tests
- **Dev tooling:** Laravel Pint (code style), Laravel Pail (log tailing), Laravel Sail (Docker)

## Developer Workflows

### Initial setup
```bash
composer run setup
# Runs: composer install → copy .env → key:generate → migrate → npm install → npm run build
```

### Start dev environment (all-in-one)
```bash
composer run dev
# Concurrently runs: php artisan serve, queue:listen, pail (logs), vite dev server
```

### Run tests
```bash
composer run test
# Clears config cache first, then runs php artisan test
# Tests use SQLite :memory: — no database setup required
```

### Code style (Pint)
```bash
./vendor/bin/pint
```

## Architecture & Conventions

### Application bootstrap
Uses Laravel 12's functional bootstrap style (`bootstrap/app.php`). Middleware, routing, and exception handling are configured there — not in `Kernel.php` (removed in L12).

### Routing
- Web routes only: `routes/web.php`
- Console commands: `routes/console.php`
- Health check endpoint: `/up` (built-in, configured in `bootstrap/app.php`)

### Frontend assets
- Entry points: `resources/css/app.css` (Tailwind), `resources/js/app.js`
- Vite ignores `storage/framework/views/**` to avoid unnecessary rebuilds
- Use `@vite(['resources/css/app.css', 'resources/js/app.js'])` in Blade layouts

### Models
- Place in `app/Models/`
- Use `$fillable` (not `$guarded`) — see `User.php` for the pattern
- Define casts via the `casts(): array` method (not the `$casts` property)
- Always declare `$hidden` for sensitive fields (passwords, tokens)

### Testing
- Feature tests in `tests/Feature/`, unit tests in `tests/Unit/`
- Tests run against SQLite in-memory; no `.env.testing` needed — overrides are in `phpunit.xml`
- Seeders use `WithoutModelEvents` trait to suppress model event side-effects during seeding

## Key Files
| File | Purpose |
|------|---------|
| `bootstrap/app.php` | App bootstrap: routing, middleware, exceptions |
| `composer.json` `scripts` | All dev/test/setup commands |
| `phpunit.xml` | Test environment overrides (DB, cache, queue, etc.) |
| `vite.config.js` | Asset pipeline with Tailwind v4 plugin |
| `routes/web.php` | All web routes |
| `app/Models/User.php` | Reference model showing fillable/hidden/casts pattern |
