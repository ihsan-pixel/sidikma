@extends('backend.layout.base')

@section('content')
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0" style="font-size: 40px">{{ $title }}</h5>
                     <img src="{{ asset('') }}storage/images/users/{{ $admin->image }}" style="width: 100px; height: 100px;border-radius: 10%; margin-right: 4%;" alt="Gambar Kosong">
                </div>
                <div class="card-body">
                    <form action="/admin/editProses" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="text" name="id" value="{{ $admin->id }}" hidden>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="full_name">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap"
                                        value="{{ $admin->nama_lengkap }}" placeholder="Masukan Nama Lengkap" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ $admin->email }}" placeholder="Masukan Email" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="no_tlp">Nomor Telepon</label>
                                    <input type="text" class="form-control" id="no_tlp" name="no_tlp"
                                        value="{{ $admin->no_tlp }}" placeholder="Masukan Nomor Telepon" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="tgl_lahir">Tanggal Lahir</label>
                                    <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir"
                                        value="{{ $admin->tgl_lahir }}" placeholder="Masukan Tanggal Lahir" required />
                                </div>
                            </div>


                         
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="role">Role</label>
                                    <select class="form-control" name="role" id="role" required>
                                        <option value="">-- Pilih --</option>
                                        @foreach ($role as $r)
                                            <option value="{{ $r }}" {{ $r == $admin->role ? 'selected' : '' }}>
                                                @if ($r == 1)
                                                    Admin
                                                @else
                                                    Kepala Sekolah
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="status">Status</label>
                                    <select class="form-control" name="status" id="status" required>
                                        <option value="">-- Pilih --</option>
                                        @foreach ($status as $s)
                                            <option value="{{ $s }}" {{ $s == $admin->status ? 'selected' : '' }}>
                                                {{ $s }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="image">Image</label>
                                    <input type="file" class="form-control" id="image" name="image"
                                        value="{{ $admin->image }}" placeholder="Masukan Gambar" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="alamat">Alamat</label>
                                    <input type="text" class="form-control" id="alamat" name="alamat"
                                        value="{{ $admin->alamat }}" placeholder="Masukan Alamat" required />
                                </div>
                            </div>

                            <div class="col-md-12">
                                <br>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="/admin" type="button" class="btn btn-success">Kembali</a>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
