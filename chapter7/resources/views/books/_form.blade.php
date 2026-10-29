@if($errors->any())
    <div class="alert error" role="alert">Please check the highlighted fields. Your changes have not been saved.</div>
@endif
<p class="form-note">Fields marked * are required.</p>
<div class="form-grid">
    <div class="field">
        <label for="title">Title *</label>
        <input id="title" name="title" value="{{ old('title', $book?->title) }}" required minlength="2" maxlength="255" @error('title') aria-invalid="true" aria-describedby="title-error" @enderror>
        <x-forms.error name="title" />
    </div>
    <div class="field">
        <label for="author">Author *</label>
        <input id="author" name="author" value="{{ old('author', $book?->author) }}" required minlength="2" maxlength="255" @error('author') aria-invalid="true" aria-describedby="author-error" @enderror>
        <x-forms.error name="author" />
    </div>
    <div class="field">
        <label for="category_id">Category *</label>
        <select id="category_id" name="category_id" required @error('category_id') aria-invalid="true" aria-describedby="category_id-error" @enderror>
            <option value="">Choose a category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected((string) old('category_id', $book?->category_id) === (string) $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
        <x-forms.error name="category_id" />
        @if($categories->isEmpty())<p class="field-error">No categories are available. Seed the database before adding books.</p>@endif
    </div>
    <div class="field">
        <label for="isbn">ISBN *</label>
        <input id="isbn" name="isbn" value="{{ old('isbn', $book?->isbn) }}" required inputmode="numeric" pattern="[0-9]{10}|[0-9]{13}" maxlength="13" aria-describedby="isbn-hint{{ $errors->has('isbn') ? ' isbn-error' : '' }}" @error('isbn') aria-invalid="true" @enderror>
        <small id="isbn-hint">10 or 13 digits, without spaces or hyphens.</small>
        <x-forms.error name="isbn" />
    </div>
    <div class="field">
        <label for="price">Price (RM) *</label>
        <input type="number" id="price" name="price" value="{{ old('price', $book?->price) }}" required min="0" max="99999999.99" step="0.01" @error('price') aria-invalid="true" aria-describedby="price-error" @enderror>
        <x-forms.error name="price" />
    </div>
    <div class="field">
        <label for="stock">Copies in stock *</label>
        <input type="number" id="stock" name="stock" value="{{ old('stock', $book?->stock ?? 0) }}" required min="0" max="1000000" step="1" @error('stock') aria-invalid="true" aria-describedby="stock-error" @enderror>
        <x-forms.error name="stock" />
    </div>
    <div class="field full-width">
        <label for="description">Description</label>
        <textarea id="description" name="description" rows="5" maxlength="5000" @error('description') aria-invalid="true" aria-describedby="description-error" @enderror>{{ old('description', $book?->description) }}</textarea>
        <x-forms.error name="description" />
    </div>
    <div class="field full-width">
        <input type="hidden" name="is_featured" value="0">
        <label class="checkbox-label" for="is_featured"><input type="checkbox" id="is_featured" name="is_featured" value="1" @checked(old('is_featured', $book?->is_featured ?? false))> Feature this book on the homepage</label>
        <x-forms.error name="is_featured" />
    </div>
</div>
<div class="form-actions"><button class="button" type="submit">{{ $submitLabel }}</button><a class="button secondary" href="{{ $book ? route('books.show', $book) : route('books.index') }}">Cancel</a></div>
