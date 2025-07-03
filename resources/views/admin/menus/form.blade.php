@extends('layouts.admin')
@section('page-title', $menu->exists ? 'Update Menu' : 'Create Menu')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
@endsection
@push('js')
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script>
        $(function() {
            $('.select2').select2({
                placeholder: "Select categories",
                allowClear: true
            });
        });
    </script>
@endpush

@section('content')
    <div class="container">
        <h2>{{ $menu->exists ? 'Update Menu' : 'Create Menu' }}</h2>
        <form action="{{ $menu->exists ? route('admin.menus.update', $menu) : route('admin.menus.store') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @if ($menu->exists)
                @method('PUT')
            @endif
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" value="{{ old('name', $menu->name) }}" class="form-control" required>
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control" required>{{ old('description', $menu->description) }}</textarea>
                @error('description')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label class="form-label" for="categories">Categories</label>
                    <select name="categories[]" id="categories" class="select2 form-select" data-allow-clear="true"
                        required>
                        <option value="">Select</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ isset($menu) && $menu->categories->contains($category->id) ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('categories')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="my-3">
                <label>Image (optional)</label>
                <input type="file" name="image" class="form-control" id="imageInput" accept="image/*">
                <div>
                    <img id="imagePreview"
                        src="{{ $menu->image && $menu->exists ? asset('storage/' . $menu->image) : '' }}" alt="Preview"
                        class="img-thumbnail mt-2" width="100"
                        style="{{ $menu->image && $menu->exists ? '' : 'display:none;' }}">
                </div>
            </div>
            <div class="mb-3">
                <label>Price</label>
                <input type="number" name="price" value="{{ old('price', $menu->price) }}" class="form-control"
                    min="0" required>
                @error('price')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <button class="btn {{ $menu->exists ? 'btn-success' : 'btn-primary' }}">
                {{ $menu->exists ? 'Update' : 'Create' }}
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
