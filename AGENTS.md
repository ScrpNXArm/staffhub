# AGENTS

This repository is a Laravel 12 HR/staff management application built with Blade views, Tailwind/Vite, and Spatie Permissions. Use this file to help AI coding assistants understand the architecture, common commands, and domain patterns without guessing.

## Key facts
- Laravel app structure: `app/`, `routes/`, `resources/views/`, `config/`.
- Auth uses Laravel Breeze and routes defined in `routes/auth.php`.
- Main domain models are `Employee`, `Department`, `LeaveRequest`, `LeaveType`, and `User`.
- Employee CRUD is implemented in `app/Http/Controllers/EmployeeController.php`.
- Dashboard is rendered by `app/Http/Controllers/DashboardController.php`.
- Role and permission management uses Spatie Permission in `config/permission.php` and `database/seeders/RoleSeeder.php`.

## Useful commands
- `composer install`
- `composer setup`
- `composer run test` or `php artisan test`
- `npm install`
- `npm run dev`
- `npm run build`
- `php artisan migrate`
- `php artisan serve`

## Conventions for code changes
- Keep controllers thin and maintain view/controller separation.
- Use Blade templates in `resources/views/` for UI updates.
- Validation is done in controllers with `$request->validate([...])`.
- `app/Models/Employee.php` controls mass assignment via `$fillable`.
- Authorization is role/permission-based rather than custom policies.
- Seeders create roles and an admin user, so preserve Spatie permission names and role assignments.

## Notes for AI agents
- Do not modify `vendor/`.
- Prefer incremental changes and keep feature additions aligned with existing CRUD patterns.
- When editing auth or permissions, verify `User.php`, `config/permission.php`, and the seeder files.
- When modifying UI, update corresponding Blade templates and ensure routes remain consistent.

## References
- [README.md](README.md)
- `composer.json`
- `routes/web.php`
- `app/Http/Controllers/EmployeeController.php`
- `app/Models/Employee.php`
- `database/seeders/RoleSeeder.php`
