# Plan: WMS Application — Full Feature Build

This plan scaffolds a complete Warehouse Management System on the existing Laravel 12 skeleton. It covers authentication with role-based access (admin/user), four core modules (materials, inventory, intake, outgoing), and a reporting section. Auth scaffolding will be added via Laravel Breeze (Blade stack). No third-party role package is needed — a simple `role` enum column on `users` is sufficient.

---

## Steps

1. **Install auth scaffolding** — run `composer require laravel/breeze --dev` then `php artisan breeze:install blade` to get login/logout/register/password-reset views and routes out of the box.

2. **Add role support** — add a `role` enum (`admin`, `user`) column to `users` via a new migration, update `app/Models/User.php` `$fillable` and `casts()`, register a `role` middleware alias in `bootstrap/app.php`, and seed a default admin user in `database/seeders/DatabaseSeeder.php`.

3. **Build Material Master Data module** — create `categories` and `materials` migrations/models, a `CategoryController` (admin-only CRUD) and `MaterialController` (admin CRUD, user read-only), and Blade views with a shared layout.

4. **Build Inventory module** — create an `inventories` table (linked to `materials`), an `Inventory` model, and a read-only `InventoryController` for both roles; inventory quantities update automatically when intake/outgoing records are saved.

5. **Build Intake and Outgoing modules** — create `intake_orders` + `intake_order_items` tables and `outgoing_orders` + `outgoing_order_items` tables with their models, controllers, and Blade views; both roles can view and create requests, but only admin can approve/confirm transactions (which triggers inventory updates).

6. **Build Reports module** — create a `ReportController` with views for: stock summary, intake history, outgoing history, and low-stock alerts; all filterable by date range and material; add optional PDF/Excel export via `barryvdh/laravel-dompdf` or `maatwebsite/excel`.

---

## Database Schema

### `users`

| Column              | Type                 | Notes          |
| ------------------- | -------------------- | -------------- |
| `id`                | bigint PK            |                |
| `name`              | string               |                |
| `email`             | string unique        |                |
| `password`          | string               | hashed         |
| `role`              | enum(`admin`,`user`) | default `user` |
| `email_verified_at` | timestamp nullable   |                |
| `remember_token`    | string nullable      |                |
| `timestamps`        |                      |                |

### `categories`

| Column       | Type      | Notes |
| ------------ | --------- | ----- |
| `id`         | bigint PK |       |
| `name`       | string    |       |
| `timestamps` |           |       |

### `materials`

| Column        | Type              | Notes                |
| ------------- | ----------------- | -------------------- |
| `id`          | bigint PK         |                      |
| `code`        | string unique     | e.g. MAT-001         |
| `name`        | string            |                      |
| `description` | text nullable     |                      |
| `category_id` | FK → categories   |                      |
| `unit`        | string            | e.g. pcs, kg, liter  |
| `min_stock`   | integer default 0 | for low-stock alerts |
| `timestamps`  |                   |                      |

### `inventories`

| Column        | Type              | Notes         |
| ------------- | ----------------- | ------------- |
| `id`          | bigint PK         |               |
| `material_id` | FK → materials    | unique        |
| `quantity`    | integer default 0 | current stock |
| `timestamps`  |                   |               |

### `intake_orders`

| Column         | Type                       | Notes             |
| -------------- | -------------------------- | ----------------- |
| `id`           | bigint PK                  |                   |
| `reference_no` | string unique              | auto-generated    |
| `supplier`     | string                     |                   |
| `received_at`  | date                       |                   |
| `user_id`      | FK → users                 | who created       |
| `status`       | enum(`pending`,`approved`) | default `pending` |
| `notes`        | text nullable              |                   |
| `timestamps`   |                            |                   |

### `intake_order_items`

| Column            | Type                   | Notes |
| ----------------- | ---------------------- | ----- |
| `id`              | bigint PK              |       |
| `intake_order_id` | FK → intake_orders     |       |
| `material_id`     | FK → materials         |       |
| `quantity`        | integer                |       |
| `unit_price`      | decimal(15,2) nullable |       |
| `timestamps`      |                        |       |

### `outgoing_orders`

| Column         | Type                       | Notes             |
| -------------- | -------------------------- | ----------------- |
| `id`           | bigint PK                  |                   |
| `reference_no` | string unique              | auto-generated    |
| `destination`  | string                     |                   |
| `issued_at`    | date                       |                   |
| `user_id`      | FK → users                 | who created       |
| `status`       | enum(`pending`,`approved`) | default `pending` |
| `notes`        | text nullable              |                   |
| `timestamps`   |                            |                   |

### `outgoing_order_items`

| Column              | Type                 | Notes |
| ------------------- | -------------------- | ----- |
| `id`                | bigint PK            |       |
| `outgoing_order_id` | FK → outgoing_orders |       |
| `material_id`       | FK → materials       |       |
| `quantity`          | integer              |       |
| `timestamps`        |                      |       |

---

## Route Structure

```
/                              → redirect to login or dashboard
/login, /logout, /register     → auth (Breeze)
/dashboard                     → both roles

/categories                    → admin: full CRUD
/materials                     → admin: full CRUD | user: index/show

/inventory                     → both roles (read-only)

/intake                        → index (both) | create/store (both) | approve (admin)
/intake/{id}                   → show (both)

/outgoing                      → index (both) | create/store (both) | approve (admin)
/outgoing/{id}                 → show (both)

/reports/stock                 → both roles
/reports/intake                → both roles
/reports/outgoing              → both roles
/reports/low-stock             → both roles
```

---

## Role Access Matrix

| Feature                             | Admin   | User         |
| ----------------------------------- | ------- | ------------ |
| Manage categories                   | ✅ CRUD | ❌           |
| Manage materials                    | ✅ CRUD | 👁 View only |
| View inventory                      | ✅      | ✅           |
| Create intake request               | ✅      | ✅           |
| Approve intake (update inventory)   | ✅      | ❌           |
| Create outgoing request             | ✅      | ✅           |
| Approve outgoing (update inventory) | ✅      | ❌           |
| View reports                        | ✅      | ✅           |
| Manage users                        | ✅      | ❌           |

---

## Packages to Install

```bash
# Auth scaffolding (Blade stack)
composer require laravel/breeze --dev
php artisan breeze:install blade

# PDF export (optional, for reports)
composer require barryvdh/laravel-dompdf

# Excel export (optional, for reports)
composer require maatwebsite/excel
```

---

## Further Considerations

1. **Role enforcement strategy** — a simple inline middleware checking `$user->role === 'admin'` works fine; alternatively Spatie `laravel-permission` offers more flexibility if roles/permissions may expand later.
2. **Inventory update mechanism** — should inventory be updated immediately on intake/outgoing record creation (simpler), or only after an admin "approves" the transaction (safer for a real warehouse workflow)? The approval flow is more realistic but adds complexity.
3. **Export packages** — `barryvdh/laravel-dompdf` (PDF) and `maatwebsite/excel` (XLSX) are the most common choices; worth deciding upfront since it affects the report views design.
4. **Reference number generation** — auto-generate `reference_no` for intake/outgoing orders (e.g. `IN-20260225-001`, `OUT-20260225-001`) using a model observer or service class.
5. **Soft deletes** — consider adding `SoftDeletes` to `materials` and order tables to preserve historical data integrity.
