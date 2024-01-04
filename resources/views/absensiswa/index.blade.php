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
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-right">
                    <button class="btn btn-primary btn-round ml-auto btn-sm" id="add_data">
                        <i class="fa fa-plus"></i>
                        Add Row
                    </button>
                    <button class="btn btn-danger btn-round btn-sm" id="add_data" onclick="javascript:confirm_del()">
                        <i class="fa fa-minus"></i>
                        Delete selected
                    </button>
                </div>
            </div>
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
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="kelas" class="col-form-label">Pilih Kelas :</label>
                                    <select class="form-control" id="datakelas" name="datakelas">
                                        <option value="">- Semua data -</option>
                                        @foreach ($kelas as $kelasdata)
                                            <option value="{{ $kelasdata->id }}">{{ $kelasdata->kelas }} -
                                                [{{ $kelasdata->tingkat }}]</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="render_mapel" class="col-form-label">Pilih Mata Pelajaran :</label>
                                    <select class="form-control" id="render_mapel" name="render_mapel">
                                        <option value="">- Semua data -</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="pertemuan" class="col-form-label">Pertemuan Ke :</label>
                                    <select class="form-control" id="pertemuan" name="pertemuan">
                                        <option value="">- Semua data -</option>
                                        @php
                                            $i = 16;
                                        @endphp

                                        @foreach (range(1, $i) as $value)
                                            <option value="{{ $value }}">{{ $value }}</option>
                                            @php
                                                $i++;
                                            @endphp
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <p>Untuk jadwal disusun oleh bagian akademik sekolah / tata usaha</p>
                    </div>

                    <table id="datatable" class="display table table-striped table-hover">
                        <thead>
                            <tr>
                                <th></th>
                                <th>NIK</th>
                                <th>NIS</th>
                                <th>Nama</th>
                                <th>TTL</th>
                                <th>KELAS</th>
                                <th>JK</th>
                                <th>Nama Ayah /Wali</th>
                                <th style="width: 10%">Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th>NIK</th>
                                <th>NIS</th>
                                <th>Nama</th>
                                <th>TTL</th>
                                <th>KELAS</th>
                                <th>JK</th>
                                <th>Nama Ayah /Wali</th>
                                <th style="width: 10%">Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets') }}/js/plugin/datatables/datatables.min.js"></script>
    <script>
        // table data
        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            order: [1, 'asc'],
            pageLength: 10,
            ajax: {
                url: "{{ route('api.laporan_presensi') }}",
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
                    data: 'nik',
                    name: 'nik'
                },
                {
                    data: 'nis',
                    name: 'nis'
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'ttl',
                    name: 'ttl'
                },
                {
                    data: 'kelas',
                    name: 'kelas'
                },

                {
                    data: 'nama_ayah',
                    name: 'nama_ayah'
                },
                {
                    data: 'jk',
                    name: 'jk',
                    render: function(data, type, row) {
                        // Assuming 'data' is the value in the 'jk' column
                        if (data === 'L') {
                            return 'Laki-Laki';
                        } else if (data === 'P') {
                            return 'Perempuan';
                        } else {
                            return 'Unknown';
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
                $.post("{{ route('master.siswa.destroy', ':id') }}", {
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
            $('#add_data').on('click', function() {
                $('#formmodal').modal('show');
                addroute = '{{ route('master.siswa.create') }}';
                $('#form_content').html('<center><h3>Loading ...</h3></center>').load(addroute);
            });

            $('select[name="datakelas"]').on('change', function() {
                var kelas_id = $(this).val();
                if (kelas_id != '') {
                    $.post('{{ Url('master/mapeldata') }}', {
                                kelas_id: kelas_id
                            },
                            function(data) {
                                option = '<option value="">Pilih Mapta Pelajaran.</option>';
                                $.each(data, function(index, value) {
                                    option += "<option value='" + value.id + "'>" +
                                        value
                                        .nama_mapel + " %</option>";
                                });
                                $('#percentage_id').html(option);
                            }, 'JSON')
                        .fail(function() {
                            swal.fire('cannot', 'can\'er  getd get data mapel', 'error');
                        });
                }
            });


            $('#datatable').on('click', '#qris', function(e) {
                e.preventDefault();
                $('#formmodal').modal('show');
                id = $(this).data('id');
                addroute = '{{ route('master.rekap_presensi.edit', ':id') }}'.replace(':id', id);
                $('#form_content').html('<center><h3>Loading Edit Data ...</h3></center>').load(
                    addroute);

            })
        });
    </script>
@endsection
