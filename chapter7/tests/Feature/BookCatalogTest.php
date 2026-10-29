<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookCatalogTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->admin()->create());
    }

    public function test_all_catalog_pages_render_and_creation_route_is_not_treated_as_an_id(): void
    {
        $book = Book::factory()->create(['is_featured' => true]);

        $this->get(route('home'))->assertOk()->assertSee($book->title);
        $this->get(route('books.index'))->assertOk()->assertSee($book->category->name);
        $this->get(route('books.show', $book))->assertOk()->assertSee($book->isbn);
        $this->get(route('books.create'))->assertOk()->assertSee('Add a book');
        $this->get(route('books.edit', $book))->assertOk()->assertSee($book->title);
    }

    public function test_valid_book_can_be_created_updated_and_deleted(): void
    {
        $category = Category::factory()->create();
        $data = $this->bookData($category);

        $response = $this->post(route('books.store'), $data);
        $book = Book::where('isbn', $data['isbn'])->firstOrFail();
        $response->assertRedirect(route('books.show', $book))->assertSessionHas('success');
        $this->assertDatabaseHas('books', ['id' => $book->id, 'category_id' => $category->id, 'title' => $data['title']]);

        $this->put(route('books.update', $book), [...$data, 'title' => 'Updated PHP Guide'])
            ->assertRedirect(route('books.show', $book))->assertSessionHas('success');
        $this->assertDatabaseHas('books', ['id' => $book->id, 'title' => 'Updated PHP Guide']);

        $this->delete(route('books.destroy', $book))->assertRedirect(route('books.index'))->assertSessionHas('success');
        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }

    public function test_invalid_submission_keeps_input_and_displays_field_errors_without_saving(): void
    {
        $category = Category::factory()->create();
        $data = [...$this->bookData($category), 'title' => '', 'price' => -1, 'stock' => 1.5, 'category_id' => 999999];

        $this->from(route('books.create'))->post(route('books.store'), $data)
            ->assertRedirect(route('books.create'))
            ->assertSessionHasErrors(['title', 'price', 'stock', 'category_id'])
            ->assertSessionHasInput('author', $data['author']);
        $this->get(route('books.create'))->assertOk()->assertSee('title-error')->assertSee($data['author']);
        $this->assertDatabaseCount('books', 0);
    }

    public function test_invalid_update_preserves_database_and_repopulates_edit_form(): void
    {
        $book = Book::factory()->create(['title' => 'Original Title']);
        $data = [...$this->bookData($book->category), 'title' => 'Unsaved Title', 'price' => -2];

        $this->from(route('books.edit', $book))->put(route('books.update', $book), $data)
            ->assertRedirect(route('books.edit', $book))->assertSessionHasErrors('price');
        $this->get(route('books.edit', $book))->assertOk()->assertSee('Unsaved Title')->assertSee('price-error');
        $this->assertSame('Original Title', $book->fresh()->title);
    }

    public function test_isbn_must_be_unique_but_a_book_can_keep_its_own_isbn(): void
    {
        $book = Book::factory()->create();
        $data = [...$this->bookData($book->category), 'isbn' => $book->isbn];

        $this->post(route('books.store'), $data)->assertSessionHasErrors('isbn');
        $this->put(route('books.update', $book), $data)->assertSessionHasNoErrors()->assertRedirect();
        $this->assertDatabaseCount('books', 1);
    }

    public function test_checkbox_can_be_unchecked_and_html_method_spoofing_works(): void
    {
        $book = Book::factory()->create(['is_featured' => true]);
        $data = $this->bookData($book->category);
        unset($data['is_featured']);
        $data['isbn'] = $book->isbn;

        $this->post(route('books.update', $book), [...$data, '_method' => 'PUT'])
            ->assertRedirect()->assertSessionHasNoErrors();
        $this->assertFalse($book->fresh()->is_featured);
        $this->post(route('books.destroy', $book), ['_method' => 'DELETE'])->assertRedirect(route('books.index'));
        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }

    public function test_missing_and_invalid_ids_return_404_instead_of_server_errors(): void
    {
        $this->get('/books/999999')->assertNotFound();
        $this->get('/books/999999/edit')->assertNotFound();
        $this->get('/books/not-a-number')->assertNotFound();
        $this->put('/books/999999', [])->assertNotFound();
        $this->delete('/books/999999')->assertNotFound();
    }

    public function test_csrf_middleware_rejects_missing_tokens_and_accepts_matching_session_tokens(): void
    {
        // Laravel normally bypasses CSRF in tests; enable the actual middleware check.
        $this->app->instance('env', 'local');
        $category = Category::factory()->create();
        $data = $this->bookData($category);

        $this->post(route('books.store'), $data)->assertStatus(419);
        $this->assertDatabaseCount('books', 0);

        $token = str_repeat('a', 40);
        $this->withSession(['_token' => $token])
            ->post(route('books.store'), [...$data, '_token' => $token])
            ->assertRedirect()->assertSessionHasNoErrors();
        $this->assertDatabaseCount('books', 1);
    }

    public function test_user_supplied_html_is_escaped_in_views(): void
    {
        $book = Book::factory()->create(['title' => '<script>alert(1)</script>', 'description' => '<img src=x onerror=alert(1)>']);

        $this->get(route('books.show', $book))->assertOk()
            ->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;', false)
            ->assertDontSee('<script>alert(1)</script>', false)
            ->assertDontSee('<img src=x onerror=alert(1)>', false);
    }

    public function test_empty_catalog_has_useful_empty_states(): void
    {
        $this->get(route('home'))->assertOk()->assertSee('No featured books yet');
        $this->get(route('books.index'))->assertOk()->assertSee('The shelf is waiting');
    }

    public function test_seeder_creates_relational_sample_data_and_is_safe_to_rerun(): void
    {
        $this->seed(DatabaseSeeder::class);
        $this->seed(DatabaseSeeder::class);

        $this->assertDatabaseCount('categories', 4);
        $this->assertDatabaseCount('books', 20);
        $this->assertSame(4, Book::where('is_featured', true)->count());
        foreach (Category::withCount('books')->get() as $category) {
            $this->assertSame(5, $category->books_count);
        }
    }

    public function test_catalog_eager_loads_categories_in_a_single_query(): void
    {
        Book::factory()->count(6)->create();
        $connection = app('db')->connection();
        $connection->enableQueryLog();

        $this->get(route('books.index'))->assertOk();

        $queries = collect($connection->getQueryLog())->filter(fn (array $query): bool => str_contains($query['query'], 'from "categories"'));
        $this->assertCount(1, $queries);
        $connection->disableQueryLog();
    }

    private function bookData(Category $category): array
    {
        return [
            'category_id' => $category->id,
            'title' => 'Practical PHP Guide',
            'author' => 'Amina Rahman',
            'isbn' => '9781234567897',
            'description' => 'A hands-on introduction to building web applications.',
            'price' => '59.90',
            'stock' => 12,
            'is_featured' => '1',
        ];
    }
}
