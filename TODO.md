# TODO

- [x] Identify where roles are checked (admin vs user) in middleware/controller.
- [ ] Fix `php artisan install:api` / migrations failure due to duplicate `categories` table.
  - [ ] Create/ensure `bootstrap/cache` directory exists and is writable.
  - [ ] Resolve duplicate migrations: disable/remove `2026_06_23_125321_create_categories_table.DISABLED.php` if already have `0001_01_01_000004_create_categories_table.php`.
  - [ ] Re-run `php artisan migrate` (or `migrate:refresh` if needed).
  - [ ] Re-run `php artisan install:api` to confirm it succeeds.

