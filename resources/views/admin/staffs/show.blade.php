@extends('layouts.admin')
@section('page-title', 'staff profile')

@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <!-- Header -->
            <div class="row">
                <div class="col-12">
                    <div class="card mb-6">
                        <div class="user-profile-header-banner">
                            <img src="../../assets/img/pages/profile-banner.png" alt="Banner image" class="rounded-top w-100" />
                        </div>
                        <div class="user-profile-header d-flex flex-column flex-lg-row text-sm-start text-center mb-5">
                            <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                                <img src="{{ $staff->image ? $staff->image_url : asset('assets/img/avatars/default.png') }}"
                                    alt="user image" width="100" height="100"
                                    class="d-block h-auto ms-0 ms-sm-6 rounded user-profile-img" />
                            </div>
                            <div class="flex-grow-1 mt-3 mt-lg-5">
                                <div
                                    class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-5 flex-md-row flex-column gap-4">
                                    <div class="user-profile-info">
                                        <h4 class="mb-2 mt-lg-6">{{ $staff->name }}</h4>
                                        <ul
                                            class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-4 my-2">
                                            <li class="list-inline-item d-flex gap-2 align-items-center">
                                                <i class="ti ti-palette ti-lg"></i><span
                                                    class="fw-medium">{{ $staff->role }}</span>
                                            </li>
                                            <li class="list-inline-item d-flex gap-2 align-items-center">
                                                <i class="ti ti-map-pin ti-lg"></i><span class="fw-medium">Gaza City</span>
                                            </li>
                                            <li class="list-inline-item d-flex gap-2 align-items-center">
                                                <i class="ti ti-calendar ti-lg"></i><span class="fw-medium"> Joined
                                                    {{ $staff->hired_at ? Illuminate\Support\Carbon::parse($staff->hired_at)->format('F Y') : 'N/A' }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <a href="{{ route('admin.staffs.edit', $staff) }}" class="btn btn-primary mb-1">
                                        <i class="ti ti-edit ti-xs me-2"></i>Edit Profile
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Header -->

            <!-- Navbar pills -->
            <div class="row">
                <div class="col-md-12">
                    <div class="nav-align-top">
                        <ul class="nav nav-pills flex-column flex-sm-row mb-6 gap-2 gap-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active" href="javascript:void(0);"><i
                                        class="ti-sm ti ti-user-check me-1_5"></i> Profile</a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
            <!--/ Navbar pills -->

            <!-- User Profile Content -->
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12">

                    <div class="card mb-6">
                        <div class="card-body">

                            <div class="d-flex justify-content-between">
                                <!-- About -->
                                <div class="w-50 me-3">

                                    <small class="card-text text-uppercase text-muted small">About</small>
                                    <ul class="list-unstyled my-3 py-1">
                                        <li class="d-flex align-items-center mb-4">
                                            <i class="ti ti-user ti-lg"></i><span class="fw-medium mx-2">Full Name:</span>
                                            <span>{{ $staff->name }}</span>
                                        </li>
                                        <li class="d-flex align-items-center mb-4">
                                            <i class="ti ti-check ti-lg"></i><span class="fw-medium mx-2">Status:</span>
                                            <span>Active</span>
                                        </li>
                                        <li class="d-flex align-items-center mb-4">
                                            <i class="ti ti-crown ti-lg"></i><span class="fw-medium mx-2">Role:</span>
                                            <span>{{ $staff->role }}</span>
                                        </li>
                                        <li class="d-flex align-items-center mb-4">
                                            <i class="ti ti-flag ti-lg"></i><span class="fw-medium mx-2">Country:</span>
                                            <span>Palestain</span>
                                        </li>
                                        <li class="d-flex align-items-center mb-2">
                                            <i class="ti ti-language ti-lg"></i><span
                                                class="fw-medium mx-2">Languages:</span>
                                            <span>Arabic</span>
                                        </li>

                                    </ul>
                                </div>

                                <!-- Contacts -->
                                <div class="w-50">

                                    <small class="card-text text-uppercase text-muted small">Contacts</small>
                                    <ul class="list-unstyled my-3 py-1">
                                        <li class="d-flex align-items-center mb-4">
                                            <i class="ti ti-phone-call ti-lg"></i><span
                                                class="fw-medium mx-2">Contact:</span>
                                            <span>{{ $staff->phone }}</span>
                                        </li>

                                        <li class="d-flex align-items-center mb-4">
                                            <i class="ti ti-mail ti-lg"></i><span class="fw-medium mx-2">Email:</span>
                                            <span>{{ $staff->email }}</span>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                <!--/ User Profile Content -->
            </div>
            <!-- / Content -->



            <div class="content-backdrop fade"></div>
        </div>
        <!-- Content wrapper -->
    @endsection

    @push('js')
        <script src="{{ asset('assets/js/pages-profile.js') }}"></script>
    @endpush
