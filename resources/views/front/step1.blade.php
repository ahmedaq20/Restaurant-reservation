@extends('layouts.guest')
@section('page-title', 'Reservation Step 1')

@section('content')
<div class="container p-5 mb-5" style="padding-top:120px;">
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <div class="bg-dark d-flex align-items-center rounded shadow">
                <div class="p-5 w-100">
                    <h5 class="section-title ff-secondary text-start text-primary fw-normal">Reservation</h5>
                    <h1 class="text-white mb-4">Book A Table Online</h1>

                    <!-- Progress Bar -->
                    <div class="mb-4">
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <small class="text-primary fw-bold">Step 1</small>
                            <small class="text-secondary">Step 2</small>
                        </div>
                    </div>
                    <!-- End Progress Bar -->

                    <!-- Info Alert -->
                    @if (session('info'))
                        <div class="alert alert-info">
                            {{ session('info') }}
                        </div>
                    @endif

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

                    <form method="POST" action="{{ route('reservation.step1') }}">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text"
                                           class="form-control @error('first_name') is-invalid @enderror"
                                           id="first_name"
                                           name="first_name"
                                           placeholder="First Name"
                                           required
                                           value="{{ old('first_name', $reservation['first_name'] ?? '') }}">
                                    <label for="first_name">First Name</label>
                                    @error('first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text"
                                           class="form-control @error('last_name') is-invalid @enderror"
                                           id="last_name"
                                           name="last_name"
                                           placeholder="Last Name"
                                           required
                                           value="{{ old('last_name', $reservation['last_name'] ?? '') }}">
                                    <label for="last_name">Last Name</label>
                                    @error('last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           id="email"
                                           name="email"
                                           placeholder="Your Email"
                                           required
                                           value="{{ old('email', $reservation['email'] ?? '') }}">
                                    <label for="email">Your Email</label>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text"
                                           class="form-control @error('tel_number') is-invalid @enderror"
                                           id="tel_number"
                                           name="tel_number"
                                           placeholder="Tel Number"
                                           required
                                           value="{{ old('tel_number', $reservation['tel_number'] ?? '') }}">
                                    <label for="tel_number">Tel Number</label>
                                    @error('tel_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="number"
                                           class="form-control @error('guest_number') is-invalid @enderror"
                                           id="guest_number"
                                           name="guest_number"
                                           placeholder="Guests"
                                           min="1"
                                           required
                                           value="{{ old('guest_number', $reservation['guest_number'] ?? '') }}">
                                    <label for="guest_number">Guests</label>
                                    @error('guest_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="datetime-local"
                                           class="form-control @error('res_date') is-invalid @enderror"
                                           id="res_date"
                                           name="res_date"
                                           required
                                           step="3600"
                                           value="{{ old('res_date', $reservation['res_date'] ?? '') }}">
                                    <label for="res_date">Reservation Date</label>
                                    @error('res_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary w-100 py-3">Next</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var resDate = document.getElementById('res_date');
    if(resDate){
        resDate.addEventListener('change', function(){
            let val = this.value;
            if(val){
                // Set minutes to 00
                let parts = val.split('T');
                if(parts.length === 2){
                    let time = parts[1].split(':');
                    if(time.length >= 2){
                        this.value = parts[0] + 'T' + time[0] + ':00';
                    }
                }
            }
        });
    }
});
</script>
@endpush
@endsection