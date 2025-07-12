use Illuminate\Validation\Rule;
@extends('layouts.admin')

@section('page-title', $staff->exists ? 'Update Staff' : 'Create Staff')

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <h2>{{ $staff->exists ? 'Update Staff' : 'Create Staff' }}</h2>
        <form
            action="{{ $staff->exists ? route('admin.staffs.update', $staff) : route('admin.staffs.store') }}"
            method="POST"
            enctype="multipart/form-data">
            @csrf
            @if ($staff->exists)
                @method('PUT')
            @endif

            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" value="{{ old('name', $staff->name) }}" class="form-control" required>
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email', $staff->email) }}" class="form-control" required>
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div> --}}

             <div class="mb-4">
                        <label for="exampleFormControlInput1" class="form-label">Email address</label>
                        <input
                          type="email"
                          name="email" value="{{ old('email', $staff->email) }}"
                          class="form-control"
                          id="exampleFormControlInput1"
                          placeholder="name@example.com"
                          required />
                          @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
                      </div>

            <div class="mb-3">
                <label>Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $staff->phone) }}" class="form-control" required>
                @error('phone')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label>Notes</label>
                <textarea name="notes" class="form-control" rows="3">{{ old('notes', $staff->notes) }}</textarea>
                @error('notes')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label>Image</label>
                <input type="file" name="image" class="form-control">
                @if ($staff->image)
                    <img src="{{ asset('storage/' . $staff->image) }}" alt="Staff Image" width="100" class="mt-2 rounded">
                @endif
                @error('image')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label>Hired At</label>
                <input type="date" name="hired_at" value="{{ old('hired_at', $staff->hired_at) }}" class="form-control">
                @error('hired_at')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label>Role</label>
                <select name="role" class="form-select" required>
                    <option value="" disabled>Select role</option>
                    @foreach (App\Enums\StaffRole::cases() as $role)
                        <option value="{{ $role->value }}"
                            {{ old('role', $staff->role) == $role->value ? 'selected' : '' }}>
                            {{ ucfirst($role->value) }}
                        </option>
                    @endforeach
                </select>
                @error('role')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button class="btn {{ $staff->exists ? 'btn-success' : 'btn-primary' }}">
                {{ $staff->exists ? 'Update' : 'Create' }}
            </button>
        </form>
    </div>
@endsection
