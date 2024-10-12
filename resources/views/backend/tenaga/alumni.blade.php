@extends('backend.layout.base')

@section('content')
    <div class="card table-responsive">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0" style="font-size: 40px">
                <b>{{ $title }}</b>
            </h5>
            <button type="button" class="btn rounded-pill btn-success justify-content-end"
                style="margin-left: 70%;">Excel</button>
        </div>
        <div class="container mt-4 ">
            <table id="datatable" class="table table-striped ">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Image</th>
                        <th>Nis</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>Kelas</th>
                        <th>Jurusan</th>
                        <th>Status</th>
                        <th>Tunggakan</th>

                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($alumni as $a)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td width="auto">
                                @if ($a->image != null)
                                    <img src="{{ asset('') }}storage/images/users/{{ $a->image }}"
                                        style="width: 40px; height: 40px;border-radius: 50%" alt="Gambar Kosong">
                                @else
                                    <img src="{{ asset('') }}storage/images/users/users.png"
                                        style="width: 40px; height: 40px;border-radius: 50%" alt="Gambar Kosong">
                                @endif
                            </td>
                            <td width="auto">{{ $a->nis }}</td>
                            <td width="auto">{{ $a->nama_lengkap }}</td>
                            <td width="auto">{{ $a->email }}</td>
                            <td width="auto">{{ $a->nama_kelas }}</td>
                            <td width="auto">{{ $a->nama_jurusan }}</td>
                            <td width="auto">
                                <button class="btn btn-info">{{ $a->status }}</button>
                            </td>
                            <td><a href="/siswa/tunggakan/{{ $a->id }}" type="button"
                                    class="btn btn-success">Tunggakan</a>
                                <a href="/pembayaran/search?&kelas_id={{ $a->kelas_id }}&nis={{ $a->nis }}"
                                    type="button" class="btn btn-danger">Pembayaran</a>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
