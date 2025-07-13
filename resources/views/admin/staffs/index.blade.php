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

        <table class="table">
            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Hired At</th>
                    <th>Notes</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($staffs as $staff)
                    <tr>
                         <td>
                            @if ($staff->image_url)
                                <img src="{{ $staff->image_url }}" width="50">
                            @endif
                        </td>
                        <td>{{ $staff->name }}</td>
                        <td>{{ $staff->email }}</td>
                        <td>{{ $staff->phone }}</td>
                        <td>{{ $staff->role }}</td>
                        <td>{{ $staff->hired_at }}</td>
                        <td>{{ $staff->notes ?? '-' }}</td>
                        <td>
                            <a href="{{ route('admin.staffs.edit', $staff) }}"
                                class="btn btn-sm btn-warning">Edit</a>
                                <a href="{{ route('admin.staffs.show', $staff) }}"
                                class="btn btn-sm btn-primary">Show</a>
                            <form action="{{ route('admin.staffs.destroy', $staff) }}" method="POST"
                                style="display:inline;">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No staffs found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4 d-flex justify-content-start">
            {{ $staffs->links() }}
        </div>
    </div>
@endsection
