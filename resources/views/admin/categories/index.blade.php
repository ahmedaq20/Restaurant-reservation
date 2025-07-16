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

        <a href="{{ route('admin.categories.create') }}" class="mb-3 btn btn-primary">New Category</a>
  
           {{-- Livewire Table Component --}}
            <livewire:table-index modelRoute="categories" :model-class="\App\Models\Category::class" />


        <div class="mt-4 d-flex justify-content-start">
            {{ $categories->links() }}
        </div>
    </div>
@endsection
