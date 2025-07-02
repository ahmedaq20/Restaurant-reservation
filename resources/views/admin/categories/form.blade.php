@extends('layouts.admin')
@section('page-title', $category->exists ? 'Update Category' : 'Create Category')

@section('content')
    <div class="container">
        <h2>{{ $category->exists ? 'Update Category' : 'Create Category' }}</h2>
        <form
            action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            @if ($category->exists)
                @method('PUT')
            @endif
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" class="form-control" required>
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control" required>{{ old('description', $category->description) }}</textarea>
                @error('description')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label>Image (optional)</label>
                <input type="file" name="image" class="form-control" id="imageInput" accept="image/*">
                <div>
                    <img id="imagePreview"
                        src="{{ $category->image ? asset('storage/' . $category->image) : '' }}"
                        alt="Preview" class="img-thumbnail mt-2"
                        width="100"
                        style="{{ $category->image ? '' : 'display:none;' }}">
                </div>
            </div>
            <button class="btn {{ $category->exists ? 'btn-success' : 'btn-primary' }}">
                {{ $category->exists ? 'Update' : 'Create' }}
            </button>
        </form>
    </div>
        <script>
        document.getElementById('imageInput').addEventListener('change', function(event) {
            const [file] = event.target.files;
            const preview = document.getElementById('imagePreview');
            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.style.display = 'block';
            } else {
                preview.src = '';
                preview.style.display = 'none';
            }
        });
    </script>
@endsection

