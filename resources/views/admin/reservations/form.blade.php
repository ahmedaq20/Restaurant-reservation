@extends('layouts.admin')

@section('page-title', $reservation->exists ? 'Update Reservation' : 'Create Reservation')

@section('content')
    <div class="container">
        <h2>{{ $reservation->exists ? 'Update Reservation' : 'Create Reservation' }}</h2>
        <form
            action="{{ $reservation->exists ? route('admin.reservations.update', $reservation) : route('admin.reservations.store') }}"
            method="POST">
            @csrf
            @if ($reservation->exists)
                @method('PUT')
            @endif

            <div class="mb-3">
                <label>First Name</label>
                <input type="text" name="first_name" value="{{ old('first_name', $reservation->first_name) }}"
                    class="form-control" required>
                @error('first_name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label>Last Name</label>
                <input type="text" name="last_name" value="{{ old('last_name', $reservation->last_name) }}"
                    class="form-control" required>
                @error('last_name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email', $reservation->email) }}" class="form-control"
                    required>
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label>Tel Number</label>
                <input type="text" name="tel_number" value="{{ old('tel_number', $reservation->tel_number) }}"
                    class="form-control" required>
                @error('tel_number')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label>Date & Time</label>
                <input type="datetime-local" name="res_date"
                    value="{{ old('res_date', $reservation->res_date ? \Carbon\Carbon::parse($reservation->res_date)->format('Y-m-d\TH:i') : '') }}"
                    class="form-control" required>
                <small class="text-muted">Reservation must be today, between 16:00 and 23:00</small>
                @error('res_date')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label>Guest Number</label>
                <input type="number" name="guest_number" value="{{ old('guest_number', $reservation->guest_number) }}"
                    class="form-control" min="1" required>
                @error('guest_number')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label>Table</label>
                <select name="table_id" class="form-select">
                    <option value="">Select</option>
                    @foreach ($tables as $table)
                        <option value="{{ $table->id }}"
                            {{ old('table_id', $reservation->table_id) == $table->id ? 'selected' : '' }}>
                            {{ $table->name }}
                        </option>
                    @endforeach
                </select>
                @error('table_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <button class="btn {{ $reservation->exists ? 'btn-success' : 'btn-primary' }}">
                {{ $reservation->exists ? 'Update' : 'Create' }}
            </button>
        </form>
    </div>
@endsection
