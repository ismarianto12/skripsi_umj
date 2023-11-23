@extends('layouts.template')
@section('content')
    @include('layouts.breadcum')

    <div class="modal fade" id="formmodal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document" style="min-width: 100%;">
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


    <style>
        .table>tbody>tr>td,
        .table>tbody>tr>th {
            padding: unset,
        }
    </style>

    <div class="col-md-12">
        <div class="card">

            <div class="card-body">
                <!-- Modal -->



                <div class="table-responsive">
                    <table id="datatable" class="display table-striped" style="width:100%;font-size:12px">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th style="width: 40%">Site ID </th>
                                <th>Site Name</th>
                                <th style="width: 30%">Nilai Sewa tahun</th>
                                <th style="width: 40%">Periode Sewa Awal</th>
                                <th style="width: 35%">Periode Sewa Akhir</th>
                                <th style="width: 44%">Nama Negosiator</th>
                                <th style="width: 10%">Buat Document</th>
                                <th style="width: 10%">Status Perpanjangan</th>
                                <th style="width: 50%">Catatan</th>
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
        $.fn.dataTable.ext.errMode = 'none';
        var table = $('#datatable').DataTable({

            "columnDefs": [{
                "width": "300px",
                "targets": 5
            }],

            processing: true,
            serverSide: true,
            responsive: true,
            order: [1, 'asc'],
            pageLength: 10,
            ajax: {
                url: "{{ route('api.tmsurat_master') }}",
                method: 'GET',
                data: function(data) {
                    data.jenis = $('#jenis').val();
                    data.contract = '{{ \Request::get('contract') ? \Request::get('contract') : '' }}';
                },
                _token: "{{ csrf_token() }}",
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                    align: 'center',
                    className: 'text-center'
                },
                {
                    data: 'site_id'
                },
                {
                    data: 'site_name'
                },

                {
                    data: 'nilai_sewa_tahun'
                },
                {
                    data: 'periode_sewa_awal'
                },
                {
                    data: 'periode_sewa_akhir'
                },
                {
                    data: 'nama_negosiator'
                },
                {
                    data: 'action'
                },
                {
                    data: 'status_perpanjangan',
                },
                {
                    data: 'catatan',
                },
            ]
        });
        $(function() {
            $('#jenis').on('change', function() {
                $('#datatable').DataTable().ajax.reload();
            });

            var num = 1;
            $('#datatable').on('change', '#jenis_suratnya', function(e) {
                e.preventDefault();
                if ($(this).val() == '') {} else {
                    var jenis = $(this).val();
                    var jumlah = ++num;
                    console.log(jumlah);
                    var site_id = $(this).find('option:selected').attr('site_id');
                    $('#formmodal').modal('show');
                    addUrl = '{{ route('master.tmsurat_master.create') }}?jenis=' + jenis + '&site_id=' +
                        site_id + '&jumlah=' + jumlah;
                    $('#form_content').html('<center><h3>Loading ...</h3></center>').load(addUrl);
                }
            });

            // edit
            $('#datatable').on('click', '#edit', function(e) {
                e.preventDefault();
                $('#formmodal').modal('show');
                id = $(this).data('id');
                addUrl = '{{ route('master.tmsurat_master.edit', ':id') }}'.replace(':id', id);
                $('#form_content').html('<center><h3>Loading Edit Data ...</h3></center>').load(addUrl);

            });
            $('#datatable').on('click', '.reset_xxs', function(e) {
                e.preventDefault();
                $('#catatan').val('');
            });

            nilai_awal = '';
            $('#datatable').on('change', '#status_perpanjangan', function(e) {
                nilai_awal = $(this).val();
            });

            $('#datatable').on('click', '.simpan_xx', function(e) {
                e.preventDefault();

                var $a = $(this);
                var status_perpanjangan = nilai_awal;
                var catatan = $(this).parent().find('textarea').val();
                var jenis_surat_id = $('#jenis_suratnya option:selected').val();
                var id_site = $(this).attr('id_site');

                $.ajax({
                    url: '{{ url('master/update_surat') }}',
                    method: 'POST',
                    data: 'status_perpanjangan=' + status_perpanjangan + '&catatan=' + catatan +
                        '&id_site=' + id_site + '&jenis_suratnya=' + jenis_surat_id,

                    dataType: 'JSON',
                    cache: false,
                    asynch: false,

                    success: function(jd) {
                        Swal.fire('success', 'Perubahan berhasil di simpan',
                            'success');
                    },
                    error: function(data) {
                        Swal.fire('success', 'Perubahan berhasil di simpan',
                            'success');
                    }
                });
                return false;

            });
        });
    </script>
@endsection
