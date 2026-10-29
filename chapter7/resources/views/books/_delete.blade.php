<form method="POST" action="{{ route('books.destroy', $book) }}" onsubmit="return confirm('Delete this book? This cannot be undone.');">
    @csrf
    @method('DELETE')
    <button type="submit" class="link-button danger" aria-label="Delete {{ $book->title }}">Delete</button>
</form>
