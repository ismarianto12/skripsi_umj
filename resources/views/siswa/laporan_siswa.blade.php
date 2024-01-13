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
                <form class="col-md-auto" id="search_data">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="fromDate" class="form-label">From Date:</label>
                                <input type="date" class="form-control" id="fromDate" name="fromDate">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="toDate" class="form-label">To Date:</label>
                                <input type="date" class="form-control" id="toDate" name="toDate">
                            </div>
                        </div>
                        <div class="col-md-4 mb-10 row" style="margin-top: 20px">
                            <button type="submit" class="btn btn-primary btn-sm" style="width: 40%;height:40px"><i
                                    class="fa fa-search"></i>Cari
                                Data</button>
                            &nbsp; &nbsp;

                            <button type="submit" class="btn btn-danger btn-sm" style="width: 40%;height:40px"
                                onclick="cleardata()"><i class="fa fa-search"></i>Clear
                                Data</button>

                        </div>

                    </div>
                </form>
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
                    <table id="datatable" class="display table table-striped table-bordered table-hover">
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
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>

    <script>
        function cleardata() {
            $('input[name="fromDate"]').val("");
            $('input[name="toDate"]').val("");
            $('#datatable').DataTable().ajax.reload();
        }
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
                url: "{{ route('api.siswa') }}",
                method: 'POST',
                _token: "{{ csrf_token() }}",
                data: function(data) {
                    data.fromDate = $('#fromDate').val();
                    data.toDate = $('#toDate').val();
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
                    data: 'nama_ayah',
                    name: 'nama_ayah'
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

            $('#search_data').on('submit', function(e) {
                e.preventDefault();
                $('#datatable').DataTable().ajax.reload();
            });
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
