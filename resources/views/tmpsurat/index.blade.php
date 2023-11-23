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
                    <button class="btn btn-danger btn-round btn-sm" onclick="javascript:confirm_del()">
                        <i class="fa fa-minus"></i>
                        Delete selected
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- Modal -->
                <div class="modal fade" id="formmodal" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document" style=" min-width: 85%;">
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
                    <table id="datatable" class="display table table-striped table-hover">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Penawaran th 1</th>
                                <th>Penawaran th 2</th>
                                <th>Penawaran th 3</th>
                                <th>Penawaran th 4</th>
                                <th>Pemilik 1</th>
                                <th>Pemilik 2</th>
                                <th>Pemilik 3</th>
                                <th>Pemilik 4</th>
                                <th>Harga sewa baru</th>
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
    <script>
        // table data
        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            order: [1, 'asc'],
            pageLength: 10,
            ajax: {
                url: "{{ route('api.tmpsurat') }}",
                method: 'GET',
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
                    data: 'penawaran_th_1',
                },
                {
                    data: 'penawaran_th_2',
                },
                {
                    data: 'penawaran_th_3',
                },
                {
                    data: 'penawaran_th_4',
                },
                {
                    data: 'pemilik_1',
                },
                {
                    data: 'pemilik_2',
                },
                {
                    data: 'pemilik_3',
                },
                {
                    data: 'pemilik_4',
                },
                {
                    data: 'harga_sewa_baru',
                },
                {
                    data: 'action',
                },

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
                $.post("{{ route('master.tmpsurat.destroy', ':id') }}", {
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
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: err,
                        showConfirmButton: false,
                        timer: 1500
                    });

                });
            }
        }

        // addd
        $(function() {
            $('#add_data').on('click', function() {
                $('#formmodal').modal('show');
                addUrl = '{{ route('master.tmpsurat.create') }}';
                $('#form_content').html('<center><h3>Loading ...</h3></center>').load(addUrl);
            });

            // edit
            $('#datatable').on('click', '#edit', function(e) {
                e.preventDefault();
                $('#formmodal').modal('show');
                id = $(this).data('id');
                addUrl = '{{ route('master.tmpsurat.edit', ':id') }}'.replace(':id', id);
                $('#form_content').html('<center><h3>Loading Edit Data ...</h3></center>').load(addUrl);

            })
        });
    </script>
@endsection
