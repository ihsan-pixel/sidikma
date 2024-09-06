@extends('backend.layout.base')

@section('content')
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0" style="font-size: 40px">{{ $title }}</h5>
                    <img src="{{ asset('') }}storage/images/users/{{ $siswa->image }}"
                        style="width: 100px; height: 100px;border-radius: 10%; margin-right: 4%;" alt="Gambar Kosong">
                </div>
                <div class="card-body">
                    <form action="/siswa/editProses" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="text" name="id" value="{{ $siswa->id }}" hidden>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="nis">EWANUGK/KARTANU</label>
                                    <input type="text" class="form-control" id="nis" name="nis"
                                        value="{{ $siswa->nis }}" placeholder="Masukan Nis" required />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="full_name">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap"
                                        value="{{ $siswa->nama_lengkap }}" placeholder="Masukan Nama Lengkap" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ $siswa->email }}" placeholder="Masukan Email" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="no_tlp">Nomor Telepon</label>
                                    <input type="text" class="form-control" id="no_tlp" name="no_tlp"
                                        value="{{ $siswa->no_tlp }}" placeholder="Masukan Nomor Telepon" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="kelas_id">Asal Madrasah</label>
                                    <select class="form-control" name="kelas_id" id="kelas_id" required>
                                        <option value="">-- Pilih --</option>
                                        @foreach ($kelas as $k)
                                            <option value="{{ $k->id }}"
                                                {{ $k->id == $siswa->kelas_id ? 'selected' : '' }}>{{ $k->nama_kelas }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="kelas_id">Status Kepegawaian</label>
                                    <select class="form-control" name="jurusan_id" id="jurusan_id" required>
                                        <option value="">-- Pilih --</option>
                                        @foreach ($jurusan as $j)
                                            <option value="{{ $j->id }}"
                                                {{ $j->id == $siswa->jurusan_id ? 'selected' : '' }}>
                                                {{ $j->nama_jurusan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="tgl_lahir">Tanggal Lahir</label>
                                    <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir"
                                        value="{{ $siswa->tgl_lahir }}" placeholder="Masukan Tanggal Lahir" required />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="no_ortu">Nomor Telepon PIC/Admin Madrasah/Sekolah</label>
                                    <input type="text" class="form-control" id="no_ortu" name="no_ortu"
                                        value="{{ $siswa->no_ortu }}" placeholder="Masukan Nomor Telepon" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="image">Image</label>
                                    <input type="file" class="form-control" id="image" name="image"
                                        placeholder="Masukan Gambar" />

                                </div>

                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="status">Status</label>
                                    <select class="form-control" name="status" id="status" required>
                                        <option value="">-- Pilih --</option>
                                        @foreach ($status as $s)
                                            <option value="{{ $s }}"
                                                {{ $s == $siswa->status ? 'selected' : '' }}>
                                                {{ $s }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="alamat">Alamat</label>
                                    <textarea type="text" class="form-control" id="alamat" name="alamat" placeholder="Masukan Alamat" required>{{ $siswa->alamat }} </textarea>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <br>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                @if (request()->user()->role == 2)
                                    <a href="/profile" type="button" class="btn btn-success">Kembali</a>
                                @else
                                    <a href="/siswa" type="button" class="btn btn-success">Kembali</a>
                                @endif

                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
