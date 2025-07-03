@extends('layouts.admin')

@php
    use App\Enums\TablesStatus;
    use App\Enums\TableLocation;
@endphp

@section('page-title', $table->exists ? 'Update Table' : 'Create Table')

@section('content')
    <div class="container">
        <h2>{{ $table->exists ? 'Update Table' : 'Create Table' }}</h2>
        <form action="{{ $table->exists ? route('admin.tables.update', $table) : route('admin.tables.store') }}"
            method="POST">
            @csrf
            @if ($table->exists)
                @method('PUT')
            @endif

            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" value="{{ old('name', $table->name) }}" class="form-control" required>
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label>Guest Number</label>
                <input type="number" name="guest_number" value="{{ old('guest_number', $table->guest_number ?? 1) }}"
                    class="form-control" min="1" required>
                @error('guest_number')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-select" required>
                    @foreach (TablesStatus::cases() as $status)
                        <option value="{{ $status->value }}"
                            {{ old('status', $table->status) == $status->value ? 'selected' : '' }}>
                            {{ ucfirst($status->value) }}
                        </option>
                    @endforeach
                </select>
                @error('status')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label>Location</label>
                <select name="location" class="form-select">
                    <option value="">Select</option>
                    @foreach (TableLocation::cases() as $location)
                        <option value="{{ $location->value }}"
                            {{ old('location', $table->location) == $location->value ? 'selected' : '' }}>
                            {{ $location->value }}
                        </option>
                    @endforeach
                </select>
                @error('location')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button class="btn {{ $table->exists ? 'btn-success' : 'btn-primary' }}">
                {{ $table->exists ? 'Update' : 'Create' }}
            </button>
        </form>
    </div>
@endsection
