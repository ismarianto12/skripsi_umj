<style>
    th {
        font-size: 10px;
    }

    td {
        font-size: 10px;
    }
</style>


@extends('layouts.template')
@section('content')
    @include('layouts.breadcum')
    <div class="page-inner">
        <div class="card">
            <div class="card-header">

                <div class="d-flex align-items-right">
                    <button class="btn btn-primary btn-round ml-auto btn-sm" id="add_data">
                        <i class="fa fa-plus"></i>
                        Add Row
                    </button>
                    <button class="btn btn-danger btn-round btn-sm" id="delete_data" onclick="javascript:confirm_del()">
                        <i class="fa fa-minus"></i>
                        Delete selected
                    </button>
                </div>
            </div>

            <div class="card-body">
                <div class="modal fade" id="formmodal" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document" style=" min-width: 65%;">
                        <div class="modal-content">
                            <div class="modal-header border-0">
                                <h5 class="modal-title" id="title">
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body" id="form_content">
                            </div>
                            <div class="modal-footer border-0">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <form id="search_data" novalidate>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="datakelas" class="col-form-label">Pilih Kelas:</label>
                                    <select class="form-control" id="datakelas" name="datakelas">
                                        <option value="">- Semua data -</option>
                                        @foreach ($kelas as $kelasdata)
                                            <option value="{{ $kelasdata->kelas }}">
                                                {{ $kelasdata->kelas }} - [{{ $kelasdata->tingkat }}]
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="pertemuan" class="col-form-label">Pertemuan</label>
                                    <select class="form-control" id="pertemuan" name="pertemuan">
                                        @php
                                            for ($i = 1; $i <= 16; $i++) {
                                                echo '<option value="' . $i . '">' . $i . '</option>';
                                            }
                                        @endphp
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="toDate" class="col-form-label">Jadwal</label>
                                    <input type="date" class="form-control" id="toDate" name="toDate">
                                </div>
                            </div>
                        </div>

                        <div class="row ml-2">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-sm" style="width: 100%">
                                        <i class="fa fa-search"></i> Cari Data
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <button type="reset" class="btn btn-danger btn-sm" style="width: 100%">
                                        <i class="fa fa-reload"></i> Reset
                                    </button>
                                </div>
                            </div>
                        </div>

                    </form>

                </div>
                <br /><br /><br /><br />
                <div class="table-responsive">

                    <table id="datatable" class="display table table-striped table-hover">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Nama Mapel</th>
                                <th>Pertemuan</th>
                                <th>Status</th>
                                <th>Pengampu</th>
                                <th style="width: 10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets') }}/js/plugin/datatables/datatables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
    <script>
        // table data

        var table = $('#datatable').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'copyHtml5',
                    className: 'btn btn-info btn-xs'
                },
                {
                    extend: 'excelHtml5',
                    className: 'btn btn-success btn-xs'
                },
                {
                    extend: 'csvHtml5',
                    className: 'btn btn-warning btn-xs'
                },
                {
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    className: 'btn btn-prirmay btn-xs'
                }
            ],
            processing: true,
            serverSide: true,
            responsive: true,
            order: [1, 'asc'],
            pageLength: 10,
            ajax: {
                url: "{{ route('api.laporan_presensi') }}",
                method: 'POST',
                _token: "{{ csrf_token() }}",
                data: function(data) {
                    var fkelas_id = $('#datakelas option:selected').val();

                    data.kelas_id = fkelas_id;
                },
            },
            columns: [{
                    data: 'id',
                    name: 'id',
                    orderable: false,
                    searchable: false,
                    align: 'center',
                    className: 'text-center'
                },

                {
                    data: 'siswa_nama',
                    name: 'siswa_nama'
                },
                {
                    data: 'kelas_id',
                    name: 'kelas_id',

                },
                {
                    data: 'nama_mapel',
                    name: 'nama_mapel',
                    render: function(data, type, row) {
                        // Assuming 'data' is the value in the 'jk' column
                        if (data) {
                            return data;
                        } else {
                            return 'Unknown';
                        }
                    }
                },
                {
                    data: 'pertemuan',
                    name: 'pertemuan'
                },
                {
                    data: 'status_hadir',
                    name: 'status_hadir',
                    render: function(data, type, row) {
                        if (data === 'H') {
                            return '<button class="btn btn-info btn-sm"><i class="fa fa-check"></i>HADIR</button>';
                        } else if (data === 'A') {
                            return '<button class="btn btn-danger btn-sm"><i class="fa fa-uncheck"></i>ALPA</button>';

                        } else if (data === 'I') {
                            return '<button class="btn btn-danger btn-sm"><i class="fa fa-uncheck"></i>IZIN</button>';

                        } else if (data === 'S') {
                            return '<button class="btn btn-danger btn-sm"><i class="fa fa-uncheck"></i>SAKIT</button>';

                        } 

                    }
                },
                {
                    data: 'guru_pengampu',
                    name: 'guru_pengampu',

                },
                {
                    data: 'action',
                    name: 'action'
                }
            ]
        });
        @include('layouts.tablechecked');

        function del() {
            var c = new Array();
            $("input:checked").each(function() {
                c.push($(this).val());
            });
            if (c.length == 0) {
                $.alert("Silahkan memilih data yang akan dihapus.");
            } else {
                $.post("{{ route('laporan.delete_presensi') }}", {
                    '_method': 'POST',
                    'id': c
                }, function(data) {
                    $('#datatable').DataTable().ajax.reload();
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Data berhasil di hapus',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }, "JSON").fail(function(data) {
                    $('#datatable').DataTable().ajax.reload();

                    err = '';
                    respon = data.responseJSON;
                    $.each(respon.errors, function(index, value) {
                        err += "<li>" + value + "</li>";
                    });

                    $.notify({
                        icon: 'flaticon-alarm-1',
                        title: 'Akses tidak bisa',
                        message: err,
                    }, {
                        type: 'secondary',
                        placement: {
                            from: "top",
                            align: "right"
                        },
                        time: 3000,
                        z_index: 2000
                    });
                });
            }
        }

        $('select[name="datakelas"]').on('change', function() {
            $('#datatable').DataTable().ajax.reload();

            var kelas_id = $(this).val();
            if (kelas_id != '') {
                $.post('{{ Url('master/mapeldata') }}', {
                            kelas_id: kelas_id
                        },
                        function(data) {
                            option = '<option value="">Pilih Mata Pelajaran.</option>';
                            $.each(data, function(index, value) {
                                option += "<option value='" + value.id + "'>" +
                                    value
                                    .nama_mapel + "</option>";
                            });
                            $('#render_mapel').html(option);
                        }, 'JSON')
                    .fail(function() {
                        swal.fire('cannot', 'can\'er  getd get data mapel', 'error');
                    });
            }
        });
        $('#search_data').on('submit', function(event) {
            event.preventDefault();

            // Show SweetAlert loading spinner
            Swal.fire({
                title: 'Checking data...',
                allowOutsideClick: false,
                showCancelButton: false,
                showConfirmButton: false,
            });
            Swal.showLoading();

            // Reload the DataTable and handle events
            var dataTable = $('#datatable').DataTable();

            // Add an event listener for the preDraw event
            dataTable.on('preDraw', function() {
                // Show SweetAlert loading spinner during DataTable reload
                Swal.fire({
                    title: 'Checking data...',
                    allowOutsideClick: false,
                    showCancelButton: false,
                    showConfirmButton: false,
                });
                Swal.showLoading();
            });

            // Add an event listener for the draw event
            dataTable.on('draw', function() {
                // Close SweetAlert loading spinner after DataTable reload
                Swal.close();
            });

            // Reload the DataTable
            dataTable.ajax.reload();
        });

        // add
        $(function() {
            $('#add_data').on('click', function() {});
            $('#datatable').on('click', '#edit', function(e) {
                e.preventDefault();
                $('#formmodal').modal('show');
                id = $(this).data('id');
                siswa_nama = $(this).data('nama');
                console.log('get id' + id);

                addroute = '{{ route('master.presensi_edit', ':id') }}'.replace(':id', id);
                $('#form_content').html('<center><h3>Loading Edit Data ...</h3></center>').load(addroute);

            })
        });
    </script>
@endsection
