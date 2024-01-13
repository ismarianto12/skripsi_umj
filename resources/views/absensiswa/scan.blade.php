<style>
    /* Aturan umum untuk kedua jenis perangkat */
    /* Misalnya, warna latar belakang umum */
    body {
        background-color: #f4f4f4;
    }

    .presensi_button {
        background: #ddd;
        right: 0;
        left: 0;
        position: fixed;
        bottom: 0;
        z-index: 999;
        width: 100%;
        margin: 0 auto;
    }

    /* Aturan khusus untuk perangkat mobile */
    @media screen and (max-width: 767px) {
        table {
            font-size: 10.5px !important;
        }

        video {
            width: 100%;
        }
    }

    /* Aturan khusus untuk perangkat desktop */
    @media screen and (min-width: 768px) {
        table {
            font-size: 14px !important;
        }

        video {
            width: 100% !important;
        }

    }
</style>

@extends('layouts.template')
@section('content')
    @include('layouts.breadcum')
    <div class="col-md-12">
        <div class="card">

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
                                    <div class="invalid-feedback">
                                        Please provide a name.
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="render_mapel" class="col-form-label">Pilih Mata Pelajaran
                                        :</label>
                                    <select class="form-control" id="rendermapel" name="render_mapel" required>
                                        <option value="">- Semua data -</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please provide a name.
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-12" style="margin-left: 20px">
                                <div class="form-group row">
                                    <button type="submit" class="btn btn-primary btn-sm" style="width: 40%">
                                        <i class="fa fa-search"></i> Cari Data
                                    </button>
                                    <button type="reset" class="btn btn-danger btn-sm" style="width: 40%">
                                        <i class="fa fa-reload"></i> Reset
                                    </button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table id="datatable" class="display table table-striped table-hover">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Nama Mapel</th>
                            <th>Kelas </th>
                            <th>Pertemuan</th>
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
                url: "{{ route('api.jadwalscan') }}",
                method: 'POST',
                _token: "{{ csrf_token() }}",
                data: function(data) {
                    var data_kelas = $(
                        '#datakelas option:selected'
                    ).val();
                    var render_mapel = $(
                        '#rendermapel option:selected'
                    ).val();
                    data.data_kelas = data_kelas;
                    data.render_mapel = data.render_mapel;
                }
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
                    name: 'nama_mapel',
                    render: function(data, type, row) {
                        if (data) {
                            return data;
                        } else {
                            return 'Unknown';
                        }
                    }
                },
                {
                    data: 'kelas_id',
                    name: 'kelas_id',
                    render: function(data, type, row) {
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
                    data: 'guru_pengampu',
                    name: 'guru_pengampu',
                    render: function(data, type, row) {
                        if (data) {
                            return data;
                        } else {
                            return 'Kosong';
                        }
                    }

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

            $('#search_data').on('submit', function(e) {
                e.preventDefault();
                $('#datatable').DataTable().ajax.reload();
            });

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
                                $('#rendermapel').html(option);
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
