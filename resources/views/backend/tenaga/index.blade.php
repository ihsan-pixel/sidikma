@extends('backend.layout.base')

@section('content')
    <div class="card table-responsive">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0" style="font-size: 40px">
                <b>{{ $title }}</b>
            </h5>
            <a href="/tenagaAdd" type="button" class="btn rounded-pill btn-primary justify-content-end"
                style="margin-left: 70%;">Add</a>
        </div>
        <div class="container mt-4 ">
            <table id="datatable" class="table table-striped ">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Image</th>
                        <th>EWANUGK</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>Asal Madrasah</th>
                        <th>Status Kepegawaian</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($tenaga as $t)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td width="auto">
                                @if ($t->image != null)
                                    <img src="{{ asset('') }}storage/images/users/{{ $t->image }}"
                                        style="width: 40px; height: 40px;border-radius: 50%" alt="Gambar Kosong">
                                @else
                                    <img src="{{ asset('') }}storage/images/users/users.png"
                                        style="width: 40px; height: 40px;border-radius: 50%" alt="Gambar Kosong">
                                @endif
                            </td>
                            <td width="auto">{{ $t->nis }}</td>
                            <td width="auto">{{ $t->nama_lengkap }}</td>
                            <td width="auto">{{ $t->email }}</td>
                            <td width="auto">{{ $t->nama_kelas }}</td>
                            <td width="auto">{{ $t->nama_jurusan }}</td>
                            <td width="auto">
                                <label class="switch switch-primary">
                                    @if ($a->status == 'ON')
                                        <input type="checkbox" readonly
                                            class="switch-input" checked />
                                    @else
                                        <input type="checkbox" readonly
                                            class="switch-input" />
                                    @endif

                                    <span class="switch-toggle-slider">
                                        <span class="switch-on">
                                            <i class="bx bx-check"></i>
                                        </span>
                                        <span class="switch-off">
                                            <i class="bx bx-x"></i>
                                        </span>
                                    </span>

                                </label>
                            </td>
                            <td>

                                <a href="/tenaga/edit/{{ $a->id }}" type="button" class="btn btn-success">Edit</a>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#delete{{ $a->id }}">Delete</button>
                            </td>
                            <div class="modal fade" id="delete{{ $a->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="deletemodal" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addNewDonaturLabel">Hapus Guru/Pegawai
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Anda yakin ingin menghapus {{ $t->nama_lengkap }}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <a href="{{ url('/tenaga/delete', $a->id) }} "
                                                    class="btn btn-primary">Hapus</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
