@extends('backend.layout.base')

@section('content')
    <!-- Header -->
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="user-profile-header-banner" style="margin-bottom: -20%;">
                    <img src="{{ asset('') }}storage/images/logo/{{ Helper::apk()->logo }}"
                        style="width: 100%; height: 40%;" alt="Banner image" class="rounded-top">
                </div>
                <hr>
                <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                    <div class="flex-shrink-12 mt-n2" style="  margin-right: -7%;">
                        @if (request()->user()->image != null)
                            <img src="{{ asset('') }}storage/images/users/{{ request()->user()->image }}"
                                style="max-width: 20%;" alt="image"
                                class="d-block h-auto ms-0 ms-sm-4 rounded user-profile-img">
                        @else
                            <img src="{{ asset('') }}storage/images/users/users.png" style="max-width: 50%;"
                                alt="image" class="d-block h-auto ms-0 ms-sm-4 rounded user-profile-img">
                        @endif
                    </div>
                    <div class="flex-grow-1 mt-5 mt-sm-5">
                        <div
                            class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                            <div class="user-profile-info"
                                style="@if (request()->user()->image != null) margin-top: 37%;
                                margin-left: -174%; @else  margin-top: 5%; @endif">
                                <h4>{{ $profile->nama_lengkap }}</h4>
                                <ul
                                    class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                                    <li class="list-inline-item fw-semibold">
                                        <i class='bx bx-mail-send'></i> {{ $profile->email }}
                                    </li>
                                    <li class="list-inline-item fw-semibold">
                                        <i class='bx bx-map'></i> {{ $profile->alamat }}
                                    </li>
                                    <li class="list-inline-item fw-semibold">
                                        <i class='bx bx-calendar-alt'></i> {{ $profile->tgl_lahir }}
                                    </li>
                                </ul>
                            </div>
                            <a href="javascript:void(0)" class="btn btn-primary text-nowrap">
                                <i class='bx bx-user-check me-1'></i>{{ $profile->status }}
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
            <ul class="nav nav-pills flex-column flex-sm-row mb-4">
                <li class="nav-item"><a class="nav-link active" href="javascript:void(0);"><i class='bx bx-user me-1'></i>
                        Profile</a></li>
                <li class="nav-item"><a class="nav-link" href="/siswa/edit/{{ $profile->id }}"><i
                            class='bx bx-edit me-1'></i>
                        Edit</a></li>
                {{-- <li class="nav-item"><a class="nav-link" href="pages-profile-projects.html"><i class='bx bx-trash me-1'></i>
                        Delete</a></li> --}}

            </ul>
        </div>
    </div>
    <!--/ Navbar pills -->

    <!-- User Profile Content -->
    <div class="row">
        <div class="col-xl-4 col-lg-5 col-md-5">
            <!-- About User -->
            <div class="card mb-4">
                <div class="card-body">
                    <small class="text-muted text-uppercase">About</small>
                    <ul class="list-unstyled mb-4 mt-3">
                        <li class="d-flex align-items-center mb-3"><i class="bx bx-user"></i><span
                                class="fw-semibold mx-2">Nama Lengkap:</span> <span>{{ $profile->nama_lengkap }}</span>
                        </li>
                        <li class="d-flex align-items-center mb-3"><i class="bx bx-check"></i><span
                                class="fw-semibold mx-2">Status:</span> <span>{{ $profile->status }}</span></li>
                        <li class="d-flex align-items-center mb-3"><i class="bx bx-star"></i><span
                                class="fw-semibold mx-2">Role:</span> <span>
                                @if ($profile->role == 1)
                                    Admin
                                @elseif ($profile->role == 2)
                                    Siswa
                                @else
                                    Kepala Sekolah
                                @endif
                            </span></li>

                        <li class="d-flex align-items-center mb-3"><i class="bx bx-flag"></i><span
                                class="fw-semibold mx-2">Negara:</span> <span>IDN</span></li>
                    </ul>
                    <small class="text-muted text-uppercase">Contacts</small>
                    <ul class="list-unstyled mb-4 mt-3">
                        <li class="d-flex align-items-center mb-3"><i class="bx bx-phone"></i><span
                                class="fw-semibold mx-2">Telephone:</span> <span>{{ $profile->no_tlp }}</span></li>

                        <li class="d-flex align-items-center mb-3"><i class="bx bx-envelope"></i><span
                                class="fw-semibold mx-2">Email:</span> <span>{{ $profile->email }}</span></li>
                    </ul>
                    @if ($profile->role == 2)
                        <small class="text-muted text-uppercase">Teams</small>
                        <ul class="list-unstyled mt-3 mb-0">
                            <li class="d-flex align-items-center mb-3"><i class="bx bx-home"></i><span
                                    class="fw-semibold mx-2">Kelas:</span> <span>{{ $profile->nama_kelas }}</span></li>
                            <li class="d-flex align-items-center mb-3"><i class="bx bx-building-house"></i><span
                                    class="fw-semibold mx-2">Kelas:</span> <span>{{ $profile->nama_jurusan }}</span></li>
                        </ul>
                    @endif
                </div>
            </div>
            <!--/ About User -->
            <!-- Profile Overview -->
            <div class="card mb-4">
                <div class="card-body">
                    <small class="text-muted text-uppercase">Overview</small>
                    <ul class="list-unstyled mt-3 mb-0">
                        <li class="d-flex align-items-center mb-3"><i class="bx bx-check"></i><span
                                class="fw-semibold mx-2">Total Siswa:</span> <span>{{ $totalsiswa }}</span></li>
                        <li class="d-flex align-items-center mb-3"><i class='bx bx-customize'></i><span
                                class="fw-semibold mx-2">Total Kelas:</span> <span>{{ $totalkelas }}</span></li>
                        <li class="d-flex align-items-center"><i class="bx bx-user"></i><span class="fw-semibold mx-2">Total
                                Jurusan:</span> <span>{{ $totaljurusan }}</span></li>
                    </ul>
                </div>
            </div>
            <!--/ Profile Overview -->
        </div>
        <div class="col-xl-8 col-lg-7 col-md-7">
            <!-- Activity Timeline -->
            {{-- <div class="card card-action mb-4">
                <div class="card-header align-items-center">
                    <h5 class="card-action-title mb-0"><i class='bx bx-list-ul me-2'></i>Activity Timeline</h5>
                    <div class="card-action-element">
                        <div class="dropdown">
                            <button type="button" class="btn dropdown-toggle hide-arrow p-0" data-bs-toggle="dropdown"
                                aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="javascript:void(0);">Share timeline</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);">Suggest edits</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="javascript:void(0);">Report bug</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="timeline ms-2">
                        <li class="timeline-item timeline-item-transparent">
                            <span class="timeline-point timeline-point-warning"></span>
                            <div class="timeline-event">
                                <div class="timeline-header mb-1">
                                    <h6 class="mb-0">Client Meeting</h6>
                                    <small class="text-muted">Today</small>
                                </div>
                                <p class="mb-2">Project meeting with john @10:15am</p>
                                <div class="d-flex flex-wrap">
                                    <div class="avatar me-3">
                                        <img src="../../assets/img/avatars/3.png" alt="Avatar"
                                            class="rounded-circle" />
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Lester McCarthy (Client)</h6>
                                        <span>CEO of Infibeam</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="timeline-item timeline-item-transparent">
                            <span class="timeline-point timeline-point-info"></span>
                            <div class="timeline-event">
                                <div class="timeline-header mb-1">
                                    <h6 class="mb-0">Create a new project for client</h6>
                                    <small class="text-muted">2 Day Ago</small>
                                </div>
                                <p class="mb-0">Add files to new design folder</p>
                            </div>
                        </li>
                        <li class="timeline-item timeline-item-transparent">
                            <span class="timeline-point timeline-point-primary"></span>
                            <div class="timeline-event">
                                <div class="timeline-header mb-1">
                                    <h6 class="mb-0">Shared 2 New Project Files</h6>
                                    <small class="text-muted">6 Day Ago</small>
                                </div>
                                <p class="mb-2">Sent by Mollie Dixon <img src="../../assets/img/avatars/4.png"
                                        class="rounded-circle ms-3" alt="avatar" height="20" width="20"></p>
                                <div class="d-flex flex-wrap gap-2">
                                    <a href="javascript:void(0)" class="me-3">
                                        <img src="../../assets/img/icons/misc/pdf.png" alt="Document image"
                                            width="20" class="me-2">
                                        <span class="h6">App Guidelines</span>
                                    </a>
                                    <a href="javascript:void(0)">
                                        <img src="../../assets/img/icons/misc/doc.png" alt="Excel image" width="20"
                                            class="me-2">
                                        <span class="h6">Testing Results</span>
                                    </a>
                                </div>
                            </div>
                        </li>
                        <li class="timeline-item timeline-item-transparent">
                            <span class="timeline-point timeline-point-success"></span>
                            <div class="timeline-event pb-0">
                                <div class="timeline-header mb-1">
                                    <h6 class="mb-0">Project status updated</h6>
                                    <small class="text-muted">10 Day Ago</small>
                                </div>
                                <p class="mb-0">Woocommerce iOS App Completed</p>
                            </div>
                        </li>
                        <li class="timeline-end-indicator">
                            <i class="bx bx-check-circle"></i>
                        </li>
                    </ul>
                </div>
            </div> --}}
            <!--/ Activity Timeline -->
            <div class="row">
                <!-- Connections -->
                <div class="col-lg-12 col-xl-6">
                    <div class="card card-action mb-4">
                        <div class="card-header align-items-center">
                            <h5 class="card-action-title mb-0">Teman Kelas</h5>
                            <div class="card-action-element">
                                {{-- <div class="dropdown">
                                    <button type="button" class="btn dropdown-toggle hide-arrow p-0"
                                        data-bs-toggle="dropdown" aria-expanded="false"><i
                                            class="bx bx-dots-vertical-rounded"></i></button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="javascript:void(0);">Share connections</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);">Suggest edits</a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:void(0);">Report bug</a></li>
                                    </ul>
                                </div> --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0"
                                style="height:310px;
                            overflow-y: scroll;">
                                @foreach ($temankelas as $tk)
                                    <li class="mb-3">
                                        <div class="d-flex align-items-start">
                                            <div class="d-flex align-items-start">
                                                <div class="avatar me-3">
                                                    @if ($tk->image != '')
                                                        <img src="{{ asset('') }}storage/images/users/{{ $tk->image }}"
                                                            class="rounded-circle" alt="img">
                                                    @else
                                                        <img src="{{ asset('') }}storage/images/users/users.png"
                                                            class="rounded-circle" alt="img">
                                                    @endif
                                                </div>
                                                <div class="me-2">
                                                    <h6 class="mb-0">{{ $tk->nama_lengkap }}</h6>
                                                    <small class="text-muted">{{ $tk->email }}</small>
                                                </div>
                                            </div>
                                            <div class="ms-auto">
                                                <button class="btn btn-label-primary btn-icon btn-sm"><i
                                                        class="bx bx-user"></i></button>
                                            </div>

                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <!--/ Connections -->
                <!-- Teams -->
                <div class="col-lg-12 col-xl-6">
                    <div class="card card-action mb-4">
                        <div class="card-header align-items-center">
                            <h5 class="card-action-title mb-0">Teman Jurusan</h5>
                            <div class="card-action-element">
                                {{-- <div class="dropdown">
                                    <button type="button" class="btn dropdown-toggle hide-arrow p-0"
                                        data-bs-toggle="dropdown" aria-expanded="false"><i
                                            class="bx bx-dots-vertical-rounded"></i></button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="javascript:void(0);">Share teams</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);">Suggest edits</a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:void(0);">Report bug</a></li>
                                    </ul>
                                </div> --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0"
                                style="height:310px;
                            overflow-y: scroll;">
                                @foreach ($temanjurusan as $tk)
                                    <li class="mb-3">
                                        <div class="d-flex align-items-start">
                                            <div class="d-flex align-items-start">
                                                <div class="avatar me-3">
                                                    @if ($tk->image != '')
                                                        <img src="{{ asset('') }}storage/images/users/{{ $tk->image }}"
                                                            class="rounded-circle" alt="img">
                                                    @else
                                                        <img src="{{ asset('') }}storage/images/users/users.png"
                                                            class="rounded-circle" alt="img">
                                                    @endif
                                                </div>
                                                <div class="me-2">
                                                    <h6 class="mb-0">{{ $tk->nama_lengkap }}</h6>
                                                    <small class="text-muted">{{ $tk->email }}</small>
                                                </div>
                                            </div>
                                            <div class="ms-auto">
                                                <button class="btn btn-label-primary btn-icon btn-sm"><i
                                                        class="bx bx-user"></i></button>
                                            </div>

                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <!--/ Teams -->
            </div>
            <!-- Projects table -->

            <!--/ Projects table -->
        </div>
    </div>
    <!--/ User Profile C
@endsection
