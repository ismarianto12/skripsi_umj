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

            <div class="card-body">
                <!-- Modal -->
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
                <div class="table-responsive">
                    @if (Auth::user()->level_id == '1')
                        <div class="card-header">
                            <div class="d-flex align-items-left">
                                <div class="d-flex align-items-center">
                                    <form id="search_data" novalidate>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="kelas" class="col-form-label">Pilih Kelas:</label>
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

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="render_mapel" class="col-form-label">Pilih Mata Pelajaran
                                                        :</label>
                                                    <select class="form-control" id="render_mapel" name="render_mapel"
                                                        required>
                                                        <option value="">- Semua data -</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Please provide a name.
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="col-md-12 row align-items-left">
                                                <div class="col-md-6">

                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-primary btn-sm"
                                                            style="width: 100%">
                                                            <i class="fa fa-search"></i> Cari Data
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">

                                                    <div class="form-group">
                                                        <button type="reset" class="btn btn-danger btn-sm"
                                                            style="width: 100%">
                                                            <i class="fa fa-reload"></i> Reset
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>

                            <div class="d-flex align-items-right">
                                <button class="btn btn-primary btn-round ml-auto btn-sm" id="add_data">
                                    <i class="fa fa-plus"></i>
                                    Add Row
                                </button>
                                <button class="btn btn-danger btn-round btn-sm" id="delete_data"
                                    onclick="javascript:confirm_del()">
                                    <i class="fa fa-minus"></i>
                                    Delete selected
                                </button>
                            </div>
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table id="datatable" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Nama Mapel</th>
                                    <th>Kelas </th>
                                    <th>Jam Mulai </th>
                                    <th>Jam Selesai </th>
                                    <th>Pertemuan</th>
                                    <th>Hari</th>
                                    <th>Guru Pengampu</th>
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
    </div>

    <script src="{{ asset('assets') }}/js/plugin/datatables/datatables.min.js"></script>
    <script>
        $.fn.dataTable.ext.errMode = 'throw';
        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            order: [1, 'asc'],
            pageLength: 10,
            ajax: {
                url: "{{ route('api.jadwal') }}",
                method: 'POST',
                _token: "{{ csrf_token() }}",
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
                    data: 'nama_mapel',
                    name: 'nama_mapel'
                },
                {
                    data: 'kelas_id',
                    name: 'kelas_id',
                    render: function(data, type, row) {
                        if (data) {
                            return data;
                        } else {
                            return 'Kosong';
                        }
                    }
                },
                {
                    data: 'jam_mulai',
                    name: 'jam_mulai',
                    render: function(data, type, row) {
                        if (data) {
                            return data;
                        } else {
                            return 'Kosong';
                        }
                    }

                },

                {
                    data: 'jam_selesai',
                    name: 'jam_selesai',
                    render: function(data, type, row) {
                        if (data) {
                            return data;
                        } else {
                            return 'Kosong';
                        }
                    }

                },
                {
                    data: 'pertemuan',
                    name: 'pertemuan'
                },
                {
                    data: 'hari',
                    name: 'hari',
                    render: function(data, type, row) {
                        if (data) {
                            return data;
                        } else {
                            return 'Kosong';
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
                $.post("{{ route('master.jadwal.destroy', ':id') }}", {
                    '_method': 'DELETE',
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



        // addd
        $(function() {

            $('select[name="datakelas"]').on('change', function() {
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

            $('#add_data').on('click', function() {
                $('#formmodal').modal('show');
                addroute = '{{ route('master.jadwal.create') }}';
                $('#form_content').html('<center><h3>Loading ...</h3></center>').load(addroute);
            });

            // edit
            $('#datatable').on('click', '#edit', function(e) {
                e.preventDefault();
                $('#formmodal').modal('show');
                id = $(this).data('id');
                addroute = '{{ route('master.jadwal.edit', ':id') }}'.replace(':id', id);
                $('#form_content').html('<center><h3>Loading Edit Data ...</h3></center>').load(addroute);

            })
        });
    </script>
@endsection
