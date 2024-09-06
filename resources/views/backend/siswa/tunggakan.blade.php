@extends('backend.layout.base')

@section('content')
    <div class="row">
        <div class="col-mb-12">
            <div class="card col-mb-12">
                <div class="card table-responsive">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <a href="/alumni" type="button" class="btn rounded-pill btn-primary justify-content-end"><i
                                class='bx bxs-chevron-left-circle'></i>Kembali</a>
                    </div>
                    <div class="container mt-4 ">
                        <table id="datatable" class="table table-striped ">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Tahun</th>
                                    <th>Pembayaran</th>
                                    <th>Tagihan</th>

                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($tunggakan as $a)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $a->nama_lengkap }}</td>
                                        <td>{{ $a->tahun }}</td>
                                        <td>{{ $a->pembayaran }}</td>
                                        <td>Rp. {{ number_format($a->tunggakan) }}</td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
