# Tech Bookstore: ready for Topic 7

This project implements the Topics 5 and 6 bookstore prerequisites on the existing Laravel 12 / PHP 8.2 installation. SQLite is already configured locally; MySQL can also be configured through `.env`.

## Run locally

```powershell
php artisan migrate
php artisan db:seed
php artisan serve
```

Open http://127.0.0.1:8000. The bookstore uses `public/css/bookstore.css` through `asset()`, so no frontend build is needed to display these pages. Optional web fonts have system font fallbacks.

The seeder adds four categories with five books each, without deleting existing data. Re-running it does not duplicate its sample titles. Keep `.env` private. The default users migration and User model remain available for the next lab.

## Completed prerequisites

- Category and Book migrations, foreign key, models, fillable fields, and casts.
- Category `hasMany` books; Book `belongsTo` category.
- Factories, sample-data seeding, and eager loading with `with('category')`.
- Shared master layout, header, footer, homepage, and catalog/detail/create/edit pages.
- Named resource routes and all seven resource actions in BookController.
- CSRF tokens and PUT/DELETE method spoofing on forms.
- Server validation for required text, unique ISBN, nonnegative price and stock, and existing category IDs.
- Preserved input, inline errors, flash messages, escaped output, empty states, and missing-record 404s.
- Feature tests for CRUD, invalid input, relationships, rendering, method spoofing, escaping, and repeated seeding.

## Manual practice checklist

1. Browse the homepage, catalog, and an individual book.
2. Add a book and check the category, price, stock, and success message.
3. Edit it while retaining its ISBN. Toggle featured status and check the homepage.
4. Submit an already-used ISBN and check the error and retained input.
5. Delete the practice book and check it disappears from the catalog.
6. Visit `/books/999999` and confirm a 404 response.

```powershell
php artisan route:list --except-vendor
php artisan test
```

Tests use a separate in-memory SQLite database, not the local catalog.

## Topic 7 completed

Both Tech Bookstore lab exercises are now implemented. See [TOPIC_7_EXERCISES.md](TOPIC_7_EXERCISES.md) for the requirement mapping, local demonstration accounts, and verification steps.

The catalog and book detail pages remain public. Creating, updating, and deleting books requires an authenticated administrator. Registration creates reader accounts. The separate Travel Portal starter-kit task is a different application and is not included in this bookstore implementation.

## Course reference

Implementation follows the supplied Topics 5 and 6 objectives and the prerequisite structure in Topic 7. Fields and styling are a working implementation of that structure; the external Google Docs code references were not available as part of the supplied file contents.
