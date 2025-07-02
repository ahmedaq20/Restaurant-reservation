@extends('layouts.admin')
@section('page-title', 'Menus')
@section('content')
    <div class="container">

        {{-- Alerts --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('deleted'))
            <div class="alert alert-danger alert-dismissible" role="alert">
                {{ session('deleted') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('warning'))
            <div class="alert alert-warning alert-dismissible" role="alert">
                {{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('updated'))
            <div class="alert alert-info alert-dismissible" role="alert">
                {{ session('updated') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('success') || session('updated') || session('deleted') || session('info'))
            <script>
                setTimeout(function() {
                    let alerts = document.querySelectorAll('.alert-dismissible');
                    alerts.forEach(function(alert) {
                        // Bootstrap 5: fade out and remove
                        alert.classList.remove('show');
                        alert.classList.add('fade');
                        setTimeout(() => alert.remove(), 500);
                    });
                }, 5000);
            </script>
        @endif
        <a href="{{ route('admin.menus.create') }}" class="btn btn-primary mb-3">New Menu</a>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($menus as $menu)
                    <tr>
                        <td>{{ $menu->name }}</td>
                        <td>{{ $menu->description }}</td>
                        <td>
                            @if ($menu->image_url)
                                <img src="{{ $menu->image_url }}" width="50">
                            @endif
                        </td>
                        <td>{{ number_format($menu->price, 2) }} $</td>
                        <td>
                            <a href="{{ route('admin.menus.edit', $menu) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.menus.destroy', $menu) }}" method="POST"
                                style="display:inline;">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No menus found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
