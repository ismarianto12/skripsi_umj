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

                    <form id="search_data" novalidate>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
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
                                <!-- Add more form elements or columns here if needed -->
                            </div>
                        </div>
                    </form>
                    <br />
                    <table id="datatable" class="display table table-striped table-hover">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Kode</th>
                                <th>Kelas</th>
                                <th>Nama</th>
                                <th>KKM</th>
                                <th style="width: 10%">Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th>Kode</th>
                                <th>Kelas</th>
                                <th>Nama</th>
                                <th>KKM</th>

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
                url: "{{ route('api.mapel') }}",
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
                    data: 'kode',
                    name: 'kode',
                    render: function(data, type, row) {
                        if (data) {
                            return data;
                        } else {
                            return 'Kosong';
                        }
                    }
                },
                {
                    data: 'kelas',
                    name: 'kelas',
                    render: function(data, type, row) {
                        if (data) {
                            return data;
                        } else {
                            return 'Kosong';
                        }
                    }
                },
                {
                    data: 'nama_mapel',
                    name: 'nama_mapel'
                },
                {
                    data: 'kkm',
                    name: 'kkm',
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
                $.post("{{ route('master.mapel.destroy', ':id') }}", {
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
 
        $(function() {
            $('select[name="datakelas"]').on('change', function() {
                Swal.showLoading();
                $('#datatable').DataTable().ajax.reload();
            });

            $('#add_data').on('click', function() {
                $('#formmodal').modal('show');
                addUrl = '{{ route('master.mapel.create') }}';
                $('#form_content').html('<center><h3>Loading ...</h3></center>').load(addUrl);
            });

            // edit
            $('#datatable').on('click', '#edit', function(e) {
                e.preventDefault();
                $('#formmodal').modal('show');
                id = $(this).data('id');
                addUrl = '{{ route('master.mapel.edit', ':id') }}'.replace(':id', id);
                $('#form_content').html('<center><h3>Loading Edit Data ...</h3></center>').load(addUrl);

            })
        });
    </script>
@endsection
