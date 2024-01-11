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
                <div class="d-flex align-items-left">
                    <form>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="fromDate" class="form-label">From Date:</label>
                                    <input type="date" class="form-control" id="fromDate" name="fromDate">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="toDate" class="form-label">To Date:</label>
                                    <input type="date" class="form-control" id="toDate" name="toDate">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-md"><i class="fa fa-search"></i>Cari
                                    Data</button>
                            </div>
                        </div>
                    </form>
                </div>

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
        </div>
    </div>

    <script src="{{ asset('assets') }}/js/plugin/datatables/datatables.min.js"></script>
    <script>
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
                    data: 'kelas',
                    name: 'kelas',
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

            // edit
            $('#datatable').on('click', '#edit', function(e) {
                e.preventDefault();
                $('#formmodal').modal('show');
                id = $(this).data('id');
                addroute = '{{ route('master.siswa.edit', ':id') }}'.replace(':id', id);
                $('#form_content').html('<center><h3>Loading Edit Data ...</h3></center>').load(addroute);

            })
        });
    </script>
@endsection
