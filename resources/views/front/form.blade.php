@extends('layouts.guest')
@section('page-title', 'title')

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
                            <div id="progressStep" class="progress-bar bg-primary" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <small id="step1Label" class="text-primary fw-bold">Step 1</small>
                            <small id="step2Label" class="text-secondary">Step 2</small>
                        </div>
                    </div>
                    <!-- End Progress Bar -->

                    <form id="reservationForm" method="POST" action="">
                        @csrf
                        <!-- Step 1 -->
                        <div id="step1">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" required>
                                        <label for="first_name">First Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" required>
                                        <label for="last_name">Last Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Your Email" required>
                                        <label for="email">Your Email</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="tel_number" name="tel_number" placeholder="Tel Number" required>
                                        <label for="tel_number">Tel Number</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" id="guest_number" name="guest_number" placeholder="Guests" min="1" required>
                                        <label for="guest_number">Guests</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="datetime-local" class="form-control" id="res_date" name="res_date" required>
                                        <label for="res_date">Reservation Date</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="button" id="nextStep" class="btn btn-primary w-100 py-3">Next</button>
                                </div>
                            </div>
                        </div>
                        <!-- Step 2 -->
                        <div id="step2" style="display:none;">
                            <div class="mb-3">
                                <label class="text-white mb-2">Choose Table</label>
                                <select class="form-select" id="table_id" name="table_id" required>
                                    <option value="">Select Table</option>
                                    @foreach($tables as $table)
                                        <option value="{{ $table->id }}" data-guests="{{ $table->guest_number }}">
                                            {{ $table->name }} (Seats: {{ $table->guest_number }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <button type="button" id="prevStep" class="btn btn-secondary w-100 py-3">Back</button>
                                </div>
                                <div class="col-6">
                                    <button type="submit" class="btn btn-success w-100 py-3">Book Now</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .navbar {
        background-color: #0f172b !important;
        transition: none !important;
    }
    /* Progress bar step label highlight */
    .step-active {
        color: #0d6efd !important;
        font-weight: bold;
    }
    .step-inactive {
        color: #6c757d !important;
        font-weight: normal;
    }
</style>

<script>
    // Step navigation
    const nextStepBtn = document.getElementById('nextStep');
    const prevStepBtn = document.getElementById('prevStep');
    const progressStep = document.getElementById('progressStep');
    const step1Label = document.getElementById('step1Label');
    const step2Label = document.getElementById('step2Label');

    nextStepBtn.onclick = function() {
        // Validate Step 1 fields
        let valid = true;
        ['first_name','last_name','email','tel_number','guest_number','res_date'].forEach(function(id){
            if(!document.getElementById(id).value) valid = false;
        });
        if(!valid) {
            alert('Please fill all fields.');
            return;
        }
        // Filter tables by guest number
        let guestNumber = parseInt(document.getElementById('guest_number').value);
        let tableSelect = document.getElementById('table_id');
        Array.from(tableSelect.options).forEach(function(option) {
            if(option.value === "") return;
            let seats = parseInt(option.getAttribute('data-guests'));
            option.style.display = (seats >= guestNumber) ? 'block' : 'none';
        });
        document.getElementById('step1').style.display = 'none';
        document.getElementById('step2').style.display = 'block';
        // Progress bar update
        progressStep.style.width = '100%';
        progressStep.setAttribute('aria-valuenow', '100');
        step1Label.classList.remove('text-primary', 'fw-bold');
        step1Label.classList.add('text-secondary');
        step2Label.classList.remove('text-secondary');
        step2Label.classList.add('text-primary', 'fw-bold');
    };

    prevStepBtn.onclick = function() {
        document.getElementById('step2').style.display = 'none';
        document.getElementById('step1').style.display = 'block';
        // Progress bar update
        progressStep.style.width = '50%';
        progressStep.setAttribute('aria-valuenow', '50');
        step2Label.classList.remove('text-primary', 'fw-bold');
        step2Label.classList.add('text-secondary');
        step1Label.classList.remove('text-secondary');
        step1Label.classList.add('text-primary', 'fw-bold');
    };
</script>
@endsection