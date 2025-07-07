@extends('layouts.guest')
@section('page-title', 'Reservation Step 2')

@section('content')
<div class="container p-5 mb-5" style="padding-top:120px;">
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <div class="bg-dark d-flex align-items-center rounded shadow">
                <div class="p-5 w-100">
                    <h5 class="section-title ff-secondary text-start text-primary fw-normal">Reservation</h5>
                    <h1 class="text-white mb-4">Choose Your Table</h1>

                    <!-- Progress Bar -->
                    <div class="mb-4">
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <small class="text-secondary">Step 1</small>
                            <small class="text-primary fw-bold">Step 2</small>
                        </div>
                    </div>
                    <!-- End Progress Bar -->

                    <!-- Validation Errors -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('reservation.step2') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="text-white mb-2">Choose Table</label>
                            <select class="form-select @error('table_id') is-invalid @enderror" name="table_id" required>
                                <option value="">Select Table</option>
                                @foreach($tables as $table)
                                    <option value="{{ $table->id }}">
                                        {{ $table->name }} (Seats: {{ $table->guest_number }})
                                    </option>
                                @endforeach
                            </select>
                            @error('table_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex">
                            <a href="{{ route('reservation.step1') }}" class="btn btn-secondary w-50 me-2 py-3">Back</a>
                            <button type="submit" class="btn btn-success w-50 py-3">Book Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection