# Topic 7: Tech Bookstore lab exercises

Both bookstore labs from the supplied Topic 7 slides are complete in this Laravel 12 project.

## Lab Exercise 1: Middleware Authentication (slides 16-19)

| Requirement | Implementation |
| --- | --- |
| Registration, login, logout | `app/Http/Controllers/AuthController.php` |
| Password hashing | `Hash::make()` during registration |
| Credential verification | `Auth::attempt()` with optional remember-me |
| Session fixation protection | Session regeneration after registration/login |
| Secure logout | POST-only route, `Auth::logout()`, session invalidation, and new CSRF token |
| Guest-only auth pages | `guest` middleware on registration/login GET and POST routes |
| Protected private endpoints | `auth` middleware on dashboard, logout, and book write routes |
| Forms and validation | `resources/views/auth/login.blade.php` and `register.blade.php` |
| Dynamic navigation | `@auth`, `@guest`, user name/account link, and CSRF-protected logout form |
| Login abuse protection | Five failed attempts per email/IP per minute; successful login clears attempts |
| Registration abuse protection | Five submissions per IP per minute |

Email addresses are normalized to lowercase. Passwords are never repopulated after a failed validation. Registration validates explicit input fields and cannot accept admin privileges.

## Lab Exercise 2: Authorization (slides 46-49)

| Requirement | Implementation |
| --- | --- |
| Administrator flag | `2026_10_15_000003_add_is_admin_to_users_table.php`, default false |
| Boolean model cast | `User::casts()` plus `User::isAdmin()` |
| Gate | `manage-books` in `app/Providers/AppServiceProvider.php` |
| Route authorization | `can:manage-books` on every book write endpoint |
| Controller authorization | `Gate::authorize('manage-books')` in create/store/edit/update/destroy |
| Conditional buttons | `@can('manage-books')` in navigation, catalog, details, and dashboard |
| Forbidden response | Branded `resources/views/errors/403.blade.php` with HTTP 403 |

The slides show `is_admin` in `$fillable`. Here it is intentionally assigned only by trusted code, so request mass assignment cannot change a reader into an administrator.

## Access matrix

| Action | Visitor | Reader | Administrator |
| --- | --- | --- | --- |
| Home, book list, book details | Allowed | Allowed | Allowed |
| Login/register | Allowed | Redirect to account | Redirect to account |
| Dashboard and POST logout | Redirect to login | Allowed | Allowed |
| Create/edit forms and book writes | Redirect to login | HTTP 403 | Allowed |

## Local demonstration accounts

| Access | Email | Password |
| --- | --- | --- |
| Administrator | admin@bookstore.test | Bookstore@123 |
| Reader | reader@bookstore.test | Bookstore@123 |

These are local lab credentials. `DemoUserSeeder` refuses to create them outside local/testing environments and does not overwrite any existing account or password. Public registration always creates readers.

```powershell
php artisan migrate
php artisan db:seed
php artisan serve
```

Open http://127.0.0.1:8000/login. The existing database was migrated without resetting the books or categories.

## Demonstration checklist

1. While logged out, browse the catalog. Add/edit/delete controls are hidden.
2. Open `/books/create` directly. You should be redirected to login.
3. Log in as the administrator. The intended creation page opens; otherwise login opens `/dashboard`.
4. Add, edit, or delete a practice book as the administrator.
5. Log out using the navigation button, then log in as the reader.
6. Reader navigation hides management controls. Opening `/books/create` directly returns 403.
7. Log out and register your own reader account. Check validation, password confirmation, and the account details page.
8. Submit five incorrect passwords for a particular email. Further attempts for that email/IP are blocked for about a minute.

## Automated verification

```powershell
php artisan test
```

26 tests / 197 assertions passed after implementing the labs. Coverage includes registration, hashed passwords, forged admin input, duplicate emails, session rotation, logout, login throttling, guest redirects, reader denials for all management endpoints, admin CRUD, CSRF checks, output escaping, and preservation of existing sample data.

## Knowledge checks

- **7.1:** B (`auth`); B (middleware confirmed login); C (named routes survive URL changes).
- **7.2:** B (authorization failure); B (Gate for global admin rule); C (hidden UI does not prevent direct requests).
- **7.3:** B (Fortify); A (Inertia uses a JavaScript frontend, Livewire uses PHP); C (`RateLimiter`).

## Separate Travel Portal task (slide 53)

The final task is a separate application requiring a fresh Livewire/Fortify starter kit, Destination model, guest/admin_assistant/admin_manager roles, approval state, and DestinationPolicy. It is not a third bookstore lab. Installing that starter kit into this application would replace the custom authentication exercise. That separate portal has not been created here.

## References

- Supplied `Topic7_ Application_Security.pptx`, slides 16-19 and 46-49.
- [Laravel 12 authentication](https://laravel.com/docs/12.x/authentication)
- [Laravel 12 authorization](https://laravel.com/docs/12.x/authorization)
- [Laravel 12 rate limiting](https://laravel.com/docs/12.x/rate-limiting)

The external Google Docs lab references were not included in the slides' text; this implementation follows the requirements visible in the supplied deck.
