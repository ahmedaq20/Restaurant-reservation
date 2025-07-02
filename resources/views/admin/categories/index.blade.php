@extends('layouts.admin')

@section('content')
    <div class="container">
        {{-- Debug: Show all session data --}}
        {{-- <pre>{{ print_r(session()->all(), true) }}</pre> --}}

        {{-- Alerts --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('deleted'))
            <div class="alert alert-danger alert-dismissible show" role="alert">
                {{ session('deleted') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('warning'))
            <div class="alert alert-warning alert-dismissible show" role="alert">
                {{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('updated'))
            <div class="alert alert-info alert-dismissible show" role="alert">
                {{ session('updated') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('success') || session('updated') || session('deleted') || session('warning'))
            <script>
                setTimeout(function() {
                    let alerts = document.querySelectorAll('.alert-dismissible');
                    alerts.forEach(function(alert) {
                        alert.classList.remove('show');
                        alert.classList.add('fade');
                        setTimeout(() => alert.remove(), 500);
                    });
                }, 5000);
            </script>
        @endif

        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary mb-3">New Category</a>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->description }}</td>
                        <td>
                            @if ($category->image_url)
                                <img src="{{  $category->image_url }}" width="50">
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.categories.edit', $category) }}"
                                class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                style="display:inline;">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
