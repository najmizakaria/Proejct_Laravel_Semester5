@extends('layouts.master')

@section('title', 'Add Destination')

@section('content')
<a href="{{ route('destinations.index') }}" class="btn btn-outline-secondary btn-sm mb-4">← Back to Catalog</a>

<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <h2 class="fw-bold mb-4">Add New Destination</h2>

        {{-- novalidate: let the SERVER do the validating so errors can be seen --}}
        <form method="POST" action="{{ route('destinations.store') }}" novalidate>
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="name" class="form-label fw-semibold">Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror">
                    <x-forms.error name="name" />
                </div>

                <div class="col-md-6">
                    <label for="country" class="form-label fw-semibold">Country</label>
                    <input type="text" id="country" name="country" value="{{ old('country') }}" class="form-control @error('country') is-invalid @enderror">
                    <x-forms.error name="country" />
                </div>

                <div class="col-md-4">
                    <label for="category_id" class="form-label fw-semibold">Category</label>
                    <select id="category_id" name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                        <option value="">-- Select a category --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <x-forms.error name="category_id" />
                </div>

                <div class="col-md-4">
                    <label for="price" class="form-label fw-semibold">Price per person ($)</label>
                    <input type="number" step="0.01" id="price" name="price" value="{{ old('price') }}" class="form-control @error('price') is-invalid @enderror">
                    <x-forms.error name="price" />
                </div>

                <div class="col-md-4">
                    <label for="rating" class="form-label fw-semibold">Rating (0 – 5)</label>
                    <input type="number" step="0.1" id="rating" name="rating" value="{{ old('rating') }}" class="form-control @error('rating') is-invalid @enderror">
                    <x-forms.error name="rating" />
                </div>

                <div class="col-12">
                    <label for="image" class="form-label fw-semibold">Image path <span class="text-muted fw-normal">(optional)</span></label>
                    <input type="text" id="image" name="image" value="{{ old('image') }}" placeholder="images/beach.jpg" class="form-control @error('image') is-invalid @enderror">
                    <div class="form-text">Path to a file inside <code>public/images</code>. Leave blank to use a placeholder.</div>
                    <x-forms.error name="image" />
                </div>

                <div class="col-12">
                    <label for="description" class="form-label fw-semibold">Description</label>
                    <textarea id="description" name="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                    <x-forms.error name="description" />
                </div>

                <div class="col-12">
                    <div class="form-check">
                        <input type="checkbox" id="is_featured" name="is_featured" value="1" class="form-check-input" @checked(old('is_featured'))>
                        <label for="is_featured" class="form-check-label">Show as a featured destination on the home page</label>
                    </div>
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary">Save Destination</button>
                <a href="{{ route('destinations.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
