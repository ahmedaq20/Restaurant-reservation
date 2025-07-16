@extends('layouts.admin')
@section('page-title', 'Tables')

@php
    use  App\Enums\TablesStatus;
@endphp
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
        <a href="{{ route('admin.tables.create') }}" class="mb-3 btn btn-primary">New Table</a>
        
        {{-- Livewire Table Component --}}
            <livewire:table-index modelRoute="tabels" :model-class="\App\Models\Table::class" />



        <div class="mt-4 d-flex justify-content-start">
            {{ $tables->links() }}
        </div>
    </div>
@endsection
