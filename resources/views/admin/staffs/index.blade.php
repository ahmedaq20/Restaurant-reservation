@extends('layouts.admin')
@section('page-title', 'Staffs')
@section('content')
    <div class="container">
        <a href="{{ route('admin.staffs.create') }}" class="mb-3 btn btn-primary">New Staff</a>
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

        @if (session('info'))
            <div class="alert alert-info alert-dismissible" role="alert">
                {{ session('info') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

<livewire:table-index modelRoute="staffs" :model-class="\App\Models\Staff::class" />

        <div class="mt-4 d-flex justify-content-start">
            {{ $staffs->links() }}
        </div>

        
       

    </div>
@endsection

