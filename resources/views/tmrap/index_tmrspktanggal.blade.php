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
                 <div class="table-responsive">
                     <table id="cdatatable" class="display table table-striped table-hover">
                         <thead>
                             <tr>
                                 <th></th>
                                 <th>Nama Proyek</th>
                                 <th>Bangunan</th>
                                 <th>Jenis RAP </th>
                                 <th>Pekerjaan</th>
                                 <th>Volume</th>
                                 <th>Satuan</th>
                                 <th>Harga Satuan</th>
                                 <th>Jumlah Harga</th>
                                 <th>Di input Oleh</th>
                                 <th style="width: 10%">Action</th>
                             </tr>
                         </thead>
                         <tfoot>
                             <tr>
                                 <th></th>
                                 <th>Nama Proyek</th>
                                 <th>Bangunan</th>
                                 <th>Jenis RAP </th>
                                 <th>Pekerjaan</th>
                                 <th>Volume</th>
                                 <th>Satuan</th>
                                 <th>Harga Satuan</th>
                                 <th>Jumlah Harga</th>
                                 <th>Di input Oleh</th>
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
         // addd
         $(function() {
             $('#add_data').on('click', function() {
                 $('#formmodal').modal('show');
                 addUrl = '{{ route('master.tmrap.create') }}';
                 $('#form_content').html('<center><h3>Loading ...</h3></center>').load(addUrl);
             });

             // edit
             $('#datatable').on('click', '#edit', function(e) {
                 e.preventDefault();
                 $('#formmodal').modal('show');
                 id = $(this).data('id');
                 addUrl = '{{ route('master.tmrap.edit', ':id') }}'.replace(':id', id);
                 $('#form_content').html('<center><h3>Loading Edit Data ...</h3></center>').load(
                     addUrl);

             })
         });
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
             order: [1, 'asc'],
             pageLength: 10,
             ajax: {
                 url: "{{ route('api.tmrap') }}",
                 method: 'POST',
                 data: function(data) {
                     data.tmproyek_id = $('#tmproyek_id').val();
                 },
                 _token: "{{ csrf_token() }}",
             },
             columns: [{
                     data: 'id',
                     name: 'nama_proyek',
                     orderable: false,
                     searchable: false,
                     align: 'center',
                     className: 'text-center'
                 },
                 {
                     data: 'namaproyek',
                     name: 'namaproyek'
                 },
                 {
                     data: 'namabangunan',
                     name: 'namabangunan',
                 },
                 {
                     data: 'jenisrapnama',
                     name: 'jenisrapnama'
                 },
                 {
                     data: 'pekerjaan',
                     name: 'pekerjaan'
                 },
                 {
                     data: 'volume',
                     name: 'volume'
                 },
                 {
                     data: 'satuan',
                     name: 'satuan'
                 },

                 {
                     data: 'harga_satuan',
                     render: $.fn.dataTable.render.number('.', '.', 2, ''),
                     name: 'harga_satuan'
                 },
                 {
                     data: 'jumlah_harga',
                     render: $.fn.dataTable.render.number('.', '.', 2, ''),
                     name: 'jumlah_harga'
                 },
                 {
                     data: 'usercreate',
                     name: 'usercreate'
                 },
                 {
                     data: 'action',
                     name: 'action'
                 }
             ]

         });
         $('select[name="tmproyek_id"]').on('change', function() {
             $('#cdatatable').DataTable().ajax.reload();
         });
         @include('layouts.tablechecked');

         function pilihdata(tmrap_id) {
             if (tmrap_id == 0) {
                 $.alert('anda tidak memilih data rap silahkan di pilih');
             } else {
                 $.post("{{ route('report.searchrap') }}", {
                     '_method': 'POST',
                     'tmrap_id': tmrap_id
                 }, function(data) {
                     $('#cdatatable').DataTable().ajax.reload();
                     Swal.fire({
                         position: 'top-end',
                         icon: 'success',
                         title: 'Data berhasil di hapus',
                         showConfirmButton: false,
                         timer: 1500
                     });
                 }, "JSON").fail(function() {
                     $('#cdatatable').DataTable().ajax.reload();
                 });
             }
         }
         $(document).ready(function() {
             $('.js-example-basic-single').select2({
                 width: '100%'
             });
         });
     </script>
