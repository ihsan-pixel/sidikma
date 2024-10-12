@extends('backend.layout.base', ['title' => 'Dashboard - Administrator - Laravel 9'])

@section('content')
<?php

date_default_timezone_set('Asia/Jakarta');

$b = time();
$hour = date('G', $b);

if ($hour >= 0 && $hour <= 11) {
    $congrat = 'Selamat Pagi :)';
} elseif ($hour >= 12 && $hour <= 14) {
    $congrat = 'Selamat Siang :) ';
} elseif ($hour >= 15 && $hour <= 17) {
    $congrat = 'Selamat Sore :) ';
} elseif ($hour >= 17 && $hour <= 18) {
    $congrat = 'Selamat Petang :) ';
} elseif ($hour >= 19 && $hour <= 23) {
    $congrat = 'Selamat Malam :) ';
}
    
    ?>
<div class="row">
    <div class="col-md-12 col-lg-15 mb-4">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-8">
                    <div class="card-body">
                        <h6 class="card-title mb-1 text-nowrap">{{ $congrat }}
                            {{ request()->user()->nama_lengkap }}
                        </h6>
                        <small class="d-block mb-3 text-nowrap">Total Pembayaran</small>
                        <h5 class="card-title text-primary mb-1">Rp. {{ number_format($totalById) }}</h5>
                        {{-- <small class="d-block mb-4 pb-1 text-muted">78% of target</small> --}}
                        <a href="/profile" class="btn btn-sm btn-primary">View profile</a>
                    </div>
                </div>
                <div class="col-4 pt-4 ps-30">
                    <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-8">
                    @if (request()->user()->image != null)
                        <img src="{{ asset('') }}storage/images/users/{{ request()->user()->image }}" width="100"
                            height="130" style="margin-bottom: 10%;" class="rounded-start" alt="">
                    @else
                        <img src="{{ asset('') }}storage/images/users/users.png" width="100" height="100"
                            style="margin-bottom: 10%;" class="rounded-start" alt="">
                    @endif
                    </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- New Visitors & Activity -->
    <div class="col-lg-15 mb-4">
        <div class="row">
            <div class="col-6 mb-4 mt">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                            <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                <div class="card-title">
                                    <h5 class="text-nowrap mb-2">Informasi User</h5>
                                    <small class="text-muted text-uppercase">About</small>
                                    <ul class="list-unstyled mb-4 mt-3">
                        <li class="d-flex align-items-center mb-3"><i class="bx bx-user"></i><span
                                class="fw-semibold mx-2">Nama Lengkap:</span> <span>{{ $profile->nama_lengkap }}</span>
                        </li>
                        @if ($profile->role == 2)
                        <ul class="list-unstyled mt-3 mb-0">
                            <li class="d-flex align-items-center mb-3"><i class="bx bx-home"></i><span
                                    class="fw-semibold mx-2">Asal Madrasah:</span> <span>{{ $profile->nama_kelas }}</span></li>
                            <li class="d-flex align-items-center mb-3"><i class="bx bx-building-house"></i><span
                                    class="fw-semibold mx-2">Status Kepegawaian:</span> <span>{{ $profile->nama_jurusan }}</span></li>
                            <li class="d-flex align-items-center mb-3"><i class="bx bx-solid bx-book"></i><span
                                    class="fw-semibold mx-2">Ketugasan:</span> <span>{{ $profile->ketugasan }}</span></li>
                            <li class="d-flex align-items-center mb-3"><i class="fa-solid fa-clock"></i><span
                                    class="fw-semibold mx-2">TMT:</span> <span>{{ $profile->tmt }}</span></li> 
                        </ul>
                    @endif
                         <li class="d-flex align-items-center mb-3"><i class="bx bx-check"></i><span
                                class="fw-semibold mx-2">Status:</span> <span>{{ $profile->status }}</span></li>
                        <li class="d-flex align-items-center mb-3"><i class="bx bx-star"></i><span
                                class="fw-semibold mx-2">Role:</span> <span>
                                @if ($profile->role == 1)
                                    Admin
                                @elseif ($profile->role == 2)
                                    Guru/Pegawai
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
                         
                                    {{-- <h5 class="text-nowrap mb-2">Pembayaran Bulanan</h5>
                                    {{-- <span class="badge bg-label-warning rounded-pill">Year 2021</span> --}}
                                </div>
                                <div class="mt-sm-auto">
                                    {{-- <small class="text-success text-nowrap fw-semibold"><i
                                            class="bx bx-chevron-up"></i>
                                        68.2%</small> --}}
                                    {{-- <h3 class="mb-0">Rp. {{ number_format($totalBulanan) }}</h3> --}}
                                </div>
                            </div>

                            <div id="profileReportChart"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card card-action mb-4">
                    <div class="card-header align-items-center">
                        <div class="d-flex justify-content-between flex-sm-row flex-column gap-0">
                            <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                <div class="card-title">
                                    {{--<div class="card-header align-items-center">--}}
                            <h5 class="text-nowrap mb-2">Rekan Se-Madrasah/Sekolah</h5>
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
                                style="height:440px;
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
                                                <div class="me-5">
                                                    <h5 class="mb-0">{{ $tk->nama_lengkap }}</h5>
                                                    <small class="text-muted">{{ $tk->nis }}</small>
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
                                    {{-- <h5 class="text-nowrap mb-2">Pembayaran Lainnya</h5>
                                    {{-- <span class="badge bg-label-warning rounded-pill">Year 2021</span> --}}
                                </div>
                                <div class="mt-sm-auto">
                                    {{-- <small class="text-success text-nowrap fw-semibold"><i
                                            class="bx bx-chevron-up"></i> --}}
                                        {{-- 68.2%</small> --}}
                                    {{-- <h3 class="mb-0">Rp. {{ number_format($totalLainya) }}</h3> --}}
                                </div>
                            </div>
                            <div id="profileReportChart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@if (request()->user()->role != 2)
    <div class="row g-4">
        <div class="col-xl-3 col-lg-3 col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <h6 class="fw-normal">Total {{ $total }}</h6>
                    </div>
                    <div class="d-flex justify-content-between align-items-end">
                        <div class="role-heading">
                            <h4 class="mb-1">Admin</h4>
                            <a href="/admin" class="role-edit-modal"><small>Edit Role</small></a>
                        </div>
                        <a href="javascript:void(0);" class="text-muted"><i class="bx bx-copy"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <h6 class="fw-normal">Total <b>{{ $kepalasekolah }}</b> </h6>

                    </div>
                    <div class="d-flex justify-content-between align-items-end">
                        <div class="role-heading">
                            <h4 class="mb-1">Super Admin</h4>
                            <a href="/admin" class="role-edit-modal"><small>Edit Role</small></a>
                        </div>
                        <a href="javascript:void(0);" class="text-muted"><i class="bx bx-copy"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <h6 class="fw-normal">Total {{ $siswatotal }}</h6>

                    </div>
                    <div class="d-flex justify-content-between align-items-end">
                        <div class="role-heading">
                            <h4 class="mb-1">Guru/Pegawai</h4>
                            <a href="/siswa" class="role-edit-modal"><small>Edit Role</small></a>
                        </div>
                        <a href="javascript:void(0);" class="text-muted"><i class="bx bx-copy"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <h6 class="fw-normal">Total All {{ $alluserstotal }} Users</h6>

                    </div>
                    <div class="d-flex justify-content-between align-items-end">
                        <div class="role-heading">
                            <h4 class="mb-1">User ALL</h4>
                            <a href="#" class="role-edit-modal"><small>Edit Role</small></a>
                        </div>
                        <a href="javascript:void(0);" class="text-muted"><i class="bx bx-copy"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
<br>
<div class="report-list-item rounded-2 ">


    <!--/ Conversion rate -->

    <div class="row">
        <div class="col-md-12 col-lg-12 mb-4 mb-md-0">
            <div class="card">
                <div class="table-responsive text-nowrap">
                    <table class="table text-nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Alamat</th>
                                <th class="text-center">Rank Payment</th>

                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @php
                                $no = 1;
                                $rank = 1;
                            @endphp
                            @foreach ($rankpayment as $rp)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>
                                        {{ $rp->nama_lengkap }}
                                    </td>
                                    <td>{{ $rp->nama_kelas }}</td>
                                    <td>
                                        {{ $rp->alamat }}
                                    </td>
                                    <td class="text-center"><span class="badge bg-label-primary ">{{ $rank++ }}</span></td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Total Balance -->

    </div>
    @endsection