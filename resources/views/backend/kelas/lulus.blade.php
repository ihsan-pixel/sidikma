@extends('backend.layout.base')

@section('content')
    <div class="card table-responsive">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0" style="font-size: 40px">
                <b>{{ $title }}</b>
            </h5>
            <a href="/kelas/add" type="button" class="btn rounded-pill btn-primary justify-content-end"
                style="margin-left: 70%;">Add</a>
        </div>
        <div class="container mt-4 ">
            <table id="datatable" class="table table-striped ">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Madrasah/Sekolah</th>
                        <th>Jml GTY Sertifikasi</th>
                        <th>Jml GTY Non Sertifikasi</th>
                        <th>Jml GTT</th>
                        <th>Jml PTY</th>
                        <th>Jml PNS</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
        





















        


    <script>
        tampil_data_from();
        $("#loading-image").hide();
        // $('#datatables').DataTable();
        function tampil_data_from() {

            // console.log($("#thajaran_id").val());
            $.ajax({
                type: 'GET',
                url: '{{ route('kelas.load_data_lulus') }}',
                async: true,
                data: {
                    jurusan_id_from: $("#jurusan_id_from").val(),
                    kelas_id_from: $("#kelas_id_from").val(),
                },
                dataType: 'json',
                beforeSend: function() {
                    $("#loading-image").show();
                },
                success: function(data) {
                    var html = '';
                    var i;
                    var no = 1;
                    for (i = 0; i < data.length; i++) {
                        html += '<tr>' +
                            '<td>' + '<input type="checkbox" class="checkboxfrom" name="getid[]" value="' +
                            data[
                                i].id + '">' +
                            '</td>' +
                            '<td>' + no++ + '</td>' +
                            '<td>' + data[i].nama_kelas + '</td>' +
                            '<td>' + data[i].nama_lengkap + '</td>' +
                            '</tr>';
                    }
                    $('#show_data').html(html);
                    $("#loading-image").hide();
                    $('#lulusbyId').removeAttr('disabled');
                    $('#datatable').DataTable();

                }
            });
        }

        $(document).ready(function() {
            $('#checkAllFrom').on('click', function(e) {
                // console.log($(this).is(':checked', true));
                if ($(this).is(':checked', true)) {
                    $(".checkboxfrom").prop('checked', true);
                    $('#datatable').DataTable();
                } else {
                    $(".checkboxfrom").prop('checked', false);
                    $('#datatable').DataTable();
                }
            });


            $('#lulusbyId').on('click', function(e) {
                // console.log($('.checkboxfrom:checked').val());
                if ($('#kelas_id_to').val() == "" || $('#jurusan_id_to').val() == "" || $(
                        '.checkboxfrom:checked').val() == undefined) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Kelas, Siswa dan Jurusan tidak boleh kosong',
                    })
                } else {
                    Swal.fire({
                        title: 'Kelulusan',
                        text: "Apakah data kelulusan sudah benar?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#lulusbyId').attr('disabled', true)
                            var checkboxes_value = [];

                            $('.checkboxfrom').each(function() {

                                if (this.checked) {
                                    checkboxes_value.push($(this).val());
                                }
                            });
                            checkboxes_value = checkboxes_value.toString();
                            $.ajax({

                                type: 'POST',
                                url: '{{ route('kelas.lulusproses') }}',
                                async: true,
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    user_id: checkboxes_value,
                                    kelas_id_to: $('#kelas_id_to').val(),
                                    jurusan_id_to: $('#jurusan_id_to').val(),
                                },
                                dataType: 'json',
                                success: function(data) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Selamat',
                                        text: 'Siswa sudah dinyatakan Lulus',
                                    });
                                    tampil_data_from();
                                    tampil_data_to();

                                }
                            });
                        }
                    });

                }

            });

        })
    </script>
@endsection
