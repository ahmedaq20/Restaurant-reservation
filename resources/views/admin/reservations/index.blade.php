@extends('layouts.admin')
@section('page-title', 'Reservations')
@section('content')
    <div class="container">
        <a href="{{ route('admin.reservations.create') }}" class="btn btn-primary mb-3">New Reservation</a>
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

        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Tel</th>
                    <th>Date</th>
                    <th>Guests</th>
                    <th>Table</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservations as $reservation)
                    <tr>
                        <td>{{ $reservation->first_name }} {{ $reservation->last_name }}</td>
                        <td>{{ $reservation->email }}</td>
                        <td>{{ $reservation->tel_number }}</td>
                        <td>{{ $reservation->res_date }}</td>
                        <td>{{ $reservation->guest_number }}</td>
                        <td>{{ $reservation->table?->name ?? '-' }}</td>
                        <td>
                            <a href="{{ route('admin.reservations.edit', $reservation) }}"
                                class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.reservations.destroy', $reservation) }}" method="POST"
                                style="display:inline;">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No reservations found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
