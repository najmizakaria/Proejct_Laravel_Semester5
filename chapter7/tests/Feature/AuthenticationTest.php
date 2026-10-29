<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use Database\Seeders\DemoUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_forms_render_and_guest_navigation_has_no_management_links(): void
    {
        $this->get(route('login'))->assertOk()->assertSee('Log in');
        $this->get(route('register'))->assertOk()->assertSee('Create account');
        $this->get(route('books.index'))->assertOk()->assertSee('Register')->assertDontSee('+ Add book');
        $this->get(route('dashboard'))->assertRedirect(route('login'));
    }

    public function test_registration_hashes_password_and_ignores_forged_admin_fields(): void
    {
        $this->withSession(['before_login' => true]);
        $oldSessionId = session()->getId();
        $this->post(route('register.store'), [
            'name' => 'New Reader', 'email' => 'READER@example.com',
            'password' => 'ReaderPass123', 'password_confirmation' => 'ReaderPass123',
            'is_admin' => true, 'role' => 'admin',
        ])->assertRedirect(route('dashboard'))->assertSessionHasNoErrors();

        $user = User::where('email', 'reader@example.com')->firstOrFail();
        $this->assertAuthenticatedAs($user);
        $this->assertTrue(Hash::check('ReaderPass123', $user->password));
        $this->assertFalse($user->is_admin);
        $this->assertNotSame($oldSessionId, session()->getId());
        $this->get(route('dashboard'))->assertOk()->assertSee('Reader');
    }

    public function test_registration_rejects_duplicate_email_and_unconfirmed_or_weak_passwords(): void
    {
        $user = User::factory()->create();
        $this->from(route('register'))->post(route('register.store'), [
            'name' => 'Another Reader', 'email' => $user->email,
            'password' => 'short', 'password_confirmation' => 'different',
        ])->assertRedirect(route('register'))->assertSessionHasErrors(['email', 'password'])
            ->assertSessionMissing('_old_input.password');
        $this->assertDatabaseCount('users', 1);
        $this->assertGuest();
    }

    public function test_login_rotates_session_and_honours_intended_destination(): void
    {
        $user = User::factory()->admin()->create();
        $this->get(route('books.create'))->assertRedirect(route('login'));
        $oldSessionId = session()->getId();
        $this->post(route('login.store'), ['email' => strtoupper($user->email), 'password' => 'password', 'remember' => '1'])
            ->assertRedirect(route('books.create'))->assertSessionHasNoErrors();

        $this->assertAuthenticatedAs($user);
        $this->assertNotSame($oldSessionId, session()->getId());
        $this->get(route('login'))->assertRedirect(route('dashboard'));
        $this->get(route('register'))->assertRedirect(route('dashboard'));
        $this->get(route('dashboard'))->assertOk()->assertSee('Administrator');
    }

    public function test_wrong_credentials_do_not_log_in_or_flash_passwords(): void
    {
        $user = User::factory()->create();
        $this->from(route('login'))->post(route('login.store'), ['email' => $user->email, 'password' => 'incorrect'])
            ->assertRedirect(route('login'))->assertSessionHasErrors('email')
            ->assertSessionHasInput('email', $user->email)->assertSessionMissing('_old_input.password');
        $this->assertGuest();
    }

    public function test_login_lockout_blocks_even_correct_password_until_decay_expires(): void
    {
        $user = User::factory()->create();
        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->post(route('login.store'), ['email' => $user->email, 'password' => 'wrong'])->assertSessionHasErrors('email');
        }

        $this->post(route('login.store'), ['email' => $user->email, 'password' => 'password'])
            ->assertSessionHasErrors('email');
        $this->assertStringContainsString('Too many login attempts.', session('errors')->first('email'));
        $this->assertGuest();
        $this->travel(61)->seconds();
        $this->post(route('login.store'), ['email' => $user->email, 'password' => 'password'])->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);
        $key = 'login:'.hash('sha256', $user->email.'|127.0.0.1');
        $this->assertSame(0, RateLimiter::attempts($key));
    }

    public function test_logout_invalidates_session_and_rotates_csrf_token(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user)->withSession(['private_marker' => 'secret', '_token' => 'old-token']);
        $oldSessionId = session()->getId();
        $this->post(route('logout'))->assertRedirect(route('home'))->assertSessionMissing('private_marker');
        $this->assertGuest();
        $this->assertNotSame('old-token', session()->token());
        $this->assertNotSame($oldSessionId, session()->getId());
        $this->get(route('dashboard'))->assertRedirect(route('login'));
        $this->get('/logout')->assertStatus(405);
    }

    public function test_guests_are_redirected_for_every_book_write_endpoint(): void
    {
        $book = Book::factory()->create();
        $this->get(route('books.create'))->assertRedirect(route('login'));
        $this->get(route('books.edit', $book))->assertRedirect(route('login'));
        $this->post(route('books.store'), [])->assertRedirect(route('login'));
        $this->put(route('books.update', $book), ['title' => 'Tampered'])->assertRedirect(route('login'));
        $this->delete(route('books.destroy', $book))->assertRedirect(route('login'));
        $this->assertDatabaseHas('books', ['id' => $book->id, 'title' => $book->title]);
    }

    public function test_readers_cannot_bypass_hidden_buttons_by_visiting_or_posting_to_admin_routes(): void
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();
        $this->actingAs($user);
        $this->get(route('books.index'))->assertOk()->assertDontSee('+ Add book')->assertDontSee('Delete '.$book->title);
        $this->get(route('books.show', $book))->assertOk()->assertDontSee('Edit book');
        $this->get(route('books.create'))->assertForbidden();
        $this->get(route('books.edit', $book))->assertForbidden();
        $this->post(route('books.store'), [])->assertForbidden();
        $this->put(route('books.update', $book), ['title' => 'Tampered'])->assertForbidden();
        $this->delete(route('books.destroy', $book))->assertForbidden();
        $this->assertDatabaseHas('books', ['id' => $book->id, 'title' => $book->title]);
    }

    public function test_admin_navigation_exposes_management_actions(): void
    {
        $book = Book::factory()->create();
        $this->actingAs(User::factory()->admin()->create());
        $this->get(route('books.index'))->assertOk()->assertSee('+ Add book')->assertSee('Delete '.$book->title);
        $this->get(route('books.show', $book))->assertOk()->assertSee('Edit book');
    }

    public function test_demo_users_are_local_only_and_rerunning_seeder_preserves_credentials(): void
    {
        $this->seed(DemoUserSeeder::class);
        $admin = User::where('email', 'admin@bookstore.test')->firstOrFail();
        $reader = User::where('email', 'reader@bookstore.test')->firstOrFail();
        $this->assertTrue($admin->is_admin);
        $this->assertFalse($reader->is_admin);
        $originalHash = $admin->password;
        $this->seed(DemoUserSeeder::class);
        $this->assertDatabaseCount('users', 2);
        $this->assertSame($originalHash, $admin->fresh()->password);

        User::query()->delete();
        $this->app->instance('env', 'production');
        $this->app->make(DemoUserSeeder::class)->run();
        $this->assertDatabaseCount('users', 0);
    }

    public function test_malformed_email_input_is_rejected_without_a_server_error(): void
    {
        $this->post(route('login.store'), ['email' => ['not-a-string'], 'password' => 'password'])->assertSessionHasErrors('email');
        $this->post(route('register.store'), ['email' => ['not-a-string']])->assertSessionHasErrors('email');
    }
}
