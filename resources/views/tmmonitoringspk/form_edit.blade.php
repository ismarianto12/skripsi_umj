 <div class="card">
     <div class="card-header">
         <div class="card-title">{{ _('Monitoring surat Perintah Kerja') }}</div>
     </div>
     <div class="ket"></div>
     <form id="exampleValidation" method="POST" class="simpan">
         <div class="card-body">

             <div class="form-group row">

                 <label for="name" class="col-md-2 text-left">Periode Awal</label>
                 <div class="col-md-4">
                     <input type="date" class="form-control" name="periode_awal" value="{{ $periode_awal }}">
                 </div>
                 <label for="name" class="col-md-2 text-left">Periode Akhir</label>
                 <div class="col-md-4">
                     <input type="date" class="form-control" name="periode_akhir" value="{{ $periode_akhir }}">
                 </div>

             </div>
             <div class="form-group row">

                 <label for="name" class="col-md-2 text-left">Surat Perintah <br />Kerja</label>
                 <div class="col-md-4">

                     <select class="form-control" name="tmrspk_id" id="tmrspk_id">
                         <option value="">--Pilih Surat --</option>

                         @foreach ($tmrspk as $f => $list)
                             @php $selected = ($list->id == $tmrspk_id) ? 'selected' :''; @endphp
                             <option value="{{ $list->id }}" {{ $selected }}>
                                 {{ $list->no_spk }} -
                                 {{ $list->nama_proyek != '' ? $list->nama_proyek : '' }}
                             </option>
                         @endforeach
                     </select>
                 </div>
                 <label for="name" class="col-md-2 text-left"> Pilih Progress <br /> SPK</label>
                 <div class="col-md-4">
                     <select class="form-control" name="percentage_id" id="percentage_id"></select>
                 </div>
             </div>

             <div class="form-group row">
                 <label for="name" class="col-md-2 text-left">
                     Nomor SPK
                 </label>

                 <div class="col-md-4">
                     <input type="text" class="form-control" name='no_spk' id="no_spk" value="{{ $no_spk }}">
                 </div>
             </div>
             {{--  --}}
             <div class="form-group row">
                 <label for="name" class="col-md-2 text-left">
                     Spk harga <br /> progres
                 </label>
                 <div class="col-md-4">
                     <input type="text" class="number_format form-control" name='spk_harga_progres'
                         value="{{ number_format($spk_harga_progres, 2) }}" readonly>
                 </div>
                 <label for="name" class="col-md-2 text-left">
                     Spk bayar lalu
                 </label>

                 <div class="col-md-4">
                     <input type="text" class="number_format form-control" name='spk_bayar_lalu'
                         value="{{ number_format($spk_bayar_lalu, 2) }}" readonly>
                 </div>
             </div>
             <div class="form-group row">
                 <label for="name" class="col-md-2 text-left">
                     Spk bayar <br /> sekarang
                 </label>
                 <div class="col-md-4">
                     <input type="text" class="number_format form-control" name='spk_bayar_sekarang'
                         value="{{ number_format($spk_bayar_sisa_skrg, 2) }}">
                 </div>

                 <label for="name" class="col-md-2 text-left">
                     Spk bayar total
                 </label>
                 <div class="col-md-4">
                     <input type="text" class="number_format form-control" name='spk_bayar_tot'
                         value="{{ number_format($spk_bayar_tot, 2) }}" value="0" readonly>
                 </div>
             </div>
             <div class="form-group row">

                 <label for="name" class="number_format col-md-2 text-left">
                     Spk bayar sisa lalu
                 </label>
                 <div class="col-md-4">
                     <input type="text" class="number_format form-control" name='spk_byr_sisa_lalu'
                         value="{{ number_format($spk_bayar_lalu, 2) }}" readonly>
                 </div>

                 <label for="name" class="number_format col-md-2 text-left">
                     Spk bayar <br /> Sisa sekarang
                 </label>
                 <div class="col-md-4">
                     <input type="text" class="number_format form-control" name='spk_bayar_sisa_skrg'
                         value="{{ number_format($spk_bayar_sisa_skrg, 2) }}" readonly>
                 </div>
             </div>
             <div class="form-group row">
                 <label for="name" class="number_format col-md-2 text-left">
                     SPK Bayar <br /> Sisa Total
                 </label>
                 <div class="col-md-4">
                     <input type="text" class="number_format form-control" name='spk_byr_sisa_total'
                         value="{{ number_format($spk_byr_sisa_total, 2) }}">
                     <input type="hidden" name="spk_jumlah_harga">
                 </div>
             </div>

             <div class="card-action">
                 <div class="row">
                     <div class="col-md-12">
                         <input class="btn btn-success" type="submit" value="Simpan">
                         <button class="btn btn-danger" type="reset">Batal</button>
                     </div>
                 </div>

             </div>
         </div>
     </form>
 </div>




 <script type="text/javascript">
     $(document).ready(function() {
         // khusus line untuk edit 


         // end line

         // format number 
         $('.number_format').keyup(function(event) {
             // skip for arrow keys
             if (event.which >= 37 && event.which <= 40) return;
             // format number
             $(this).val(function(index, value) {
                 return value
                     .replace(/\D/g, "")
                     .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
             });
         });

         function parseCurrency(num) {
             return parseFloat(num.replace(/,/g, ''));
         }
         // if get  input value in texboxt  
         // if change function 
         tmspkval_id = '{{ $tmrspk_id }}';
         $.post('{{ route('api.getparentspk') }}', {
                     tmrspk_id: tmspkval_id,
                     percentage: 'yes',
                 },
                 function(data) {
                     option = '<option value="">Pilih Persentase</option>';
                     $.each(data, function(index, value) {
                         option += "<option value='" + value.spk_progress_tot + "'>" +
                             value
                             .spk_progress_tot + " %</option>";
                     });
                     $('#percentage_id').html(option);
                 }, 'JSON')
             .fail(function() {
                 swal.fire('cannot', 'cant response page server error', 'error');
             });

         $.post('{{ route('api.gettotal_lalu') }}', {
             tmrspk_id: tmspkval_id
         }, function(data) {
             $('input[name="spk_byr_sisa_lalu"]').val(currency(data.spk_byr_sisa_lalu));
         }).fail(function(data) {
             swal.fire('cannot', 'cant response page server error', 'error');

         });
         $('select[name="tmrspk_id"]').on('change', function() {
             var val_id = $(this).val();
             if (val_id != '') {
                 $.post('{{ route('api.gettotal_lalu') }}', {
                     tmrspk_id: val_id
                 }, function(data) {
                     cek_ada = (data.spk_byr_sisa_lalu) ? data.spk_byr_sisa_lalu : 0;
                     $('input[name="spk_byr_sisa_lalu"]').val(currency(cek_ada)).attr(
                         'readonly',
                         true);
                 }).fail(function(data) {
                     swal.fire('cannot', 'cant response page server error', 'error');

                 });



                 $.post('{{ route('api.getparentspk') }}', {
                             tmrspk_id: val_id,
                             percentage: 'yes',
                         },
                         function(data) {
                             option = '<option value="">Pilih Persentase</option>';
                             $.each(data, function(index, value) {
                                 option += "<option value='" + value.spk_progress_tot + "'>" +
                                     value
                                     .spk_progress_tot + " %</option>";
                             });
                             $('#percentage_id').html(option);
                         }, 'JSON')
                     .fail(function() {
                         swal.fire('cannot', 'cant response page server error', 'error');
                     });
             }

         });

         spk_progress_tot = '{{ $persentase }}';
         tmrspk_id = $('select[name="tmrspk_id"]').val();
         $.post('{{ route('api.getspkprogress') }}', {
             tmrspk_id: tmrspk_id,
             spk_progress_tot: spk_progress_tot
         }, function(data) {
             $('#percentage_id').val(data.spk_progress_tot).prop('selected', true);

             $('input[name="spk_byr_sisa_total"]').val(0).attr('readonly', true);
             $('#no_spk').val(data.no_spk).attr('readonly',
                 true);
             $('input[name="spk_harga_progres"]').val(currency(data.spk_jumlah_harga)).attr(
                 'readonly', true);
             $('input[name="spk_bayar_lalu"]').val(currency(data.spk_bayar_lalu)).attr(
                 'readonly', true);
             $('input[name="spk_bayar_sekarang"]').val(currency(data.spk_bayar_sekarang));

             $('input[name="spk_bayar_sisa_skrg"]').val(currency(data.spk_bayar_sisa_skrg))
                 .attr('readonly', true);

             $('input[name="spk_jumlah_harga"]').val(parseInt(data.spk_jumlah_harga)).attr(
                 'readonly', true);
             $('input[name="spk_harga_satuan"]').val(currency(data.spk_harga_satuan)).attr(
                 'readonly', true);

         }, 'JSON');

         // jika ada handling yang lain 

         // if select the percentage_id 
         $('#percentage_id').on('change', function(e) {
             spk_progress_tot = $(this).val();
             tmrspk_id = $('select[name="tmrspk_id"]').val();
             $.post('{{ route('api.getspkprogress') }}', {
                 tmrspk_id: tmrspk_id,
                 spk_progress_tot: spk_progress_tot
             }, function(data) {
                 //  $('select[name="tmrspk_id"]').val(data.spk_progress_tot).props('selected');

                 $('input[name="spk_byr_sisa_total"]').val(0).attr('readonly', true);
                 $('#no_spk').val(data.no_spk).attr('readonly',
                     true);
                 $('input[name="spk_harga_progres"]').val(currency(data.spk_jumlah_harga)).attr(
                     'readonly', true);
                 $('input[name="spk_bayar_lalu"]').val(currency(data.spk_bayar_lalu)).attr(
                     'readonly', true);
                 $('input[name="spk_bayar_sekarang"]').val(currency(data.spk_bayar_sekarang));

                 $('input[name="spk_bayar_sisa_skrg"]').val(currency(data.spk_bayar_sisa_skrg))
                     .attr('readonly', true);

                 $('input[name="spk_jumlah_harga"]').val(parseInt(data.spk_jumlah_harga)).attr(
                     'readonly', true);
                 $('input[name="spk_harga_satuan"]').val(currency(data.spk_harga_satuan)).attr(
                     'readonly', true);

             }, 'JSON');
         });
         // parsed by currency access here

         $('input').keyup(function() {
             // get hiutung jumlah spk di aplikasi .
             var spk_harga_progres = parseCurrency($('input[name="spk_harga_progres"]').val());
             var spk_bayar_sekarang = parseCurrency($('input[name="spk_bayar_sekarang"]').val());
             var spk_byr_sisa_lalu = parseCurrency($('input[name="spk_byr_sisa_lalu"]').val());
             var spk_bayar_sisa_skrg = parseCurrency($('input[name="spk_bayar_sisa_skrg"]').val());
             var spk_bayar_tot = parseCurrency($('input[name="spk_bayar_tot"]').val());
             var spk_jumlah_harga = parseCurrency($('input[name="spk_jumlah_harga"]').val());
             var spk_bayar_lalu = parseCurrency($('input[name="spk_bayar_lalu"]').val());

             // a. Spk di bayar total 
             var nilai_bayar_total = parseInt(spk_bayar_lalu + spk_bayar_sekarang);
             var nilai_spk_byr_sisa_lalu = parseInt(spk_jumlah_harga - nilai_bayar_total);

             $('input[name="spk_bayar_sisa_skrg"]').val(currency(nilai_spk_byr_sisa_lalu)).attr(
                 'readonly', true);
             $('input[name="spk_bayar_tot"]').val(currency(nilai_bayar_total)).attr('readonly', true);
             // spk  bayar total (SPK BAYAR LALU + SPK DI BAYAR SEKARANG) - SPK JUMLAH HARGA DI TABLE MASTER SPK 
             $('input[name="spk_byr_sisa_total"]').val(currency(nilai_bayar_total)).attr('readonly',
                 true);
         });
     });

     $(function() {
         $('.simpan').on('submit', function(e) {
             e.preventDefault();
             $.ajax({
                 url: "{{ route('master.monitoringspk.update', $id) }}",
                 method: "PUT",
                 data: $(this).serialize(),
                 chace: false,
                 async: false,
                 success: function(data) {
                     $('#datatable').DataTable().ajax.reload();
                     $('#formmodal').modal('hide');
                     Swal.fire({
                         position: 'top-end',
                         icon: 'success',
                         title: 'Data berhasil di simpan',
                         showConfirmButton: false,
                         timer: 1500
                     })
                 },
                 error: function(data) {
                     var div = $('#container');
                     setInterval(function() {
                         var pos = div.scrollTop();
                         div.scrollTop(pos + 2);
                     }, 10)
                     err = '';
                     respon = data.responseJSON;
                     $.each(respon.errors, function(index, value) {
                         err += "<li>" + value + "</li>";
                     });

                     $.notify({
                         icon: 'flaticon-alarm-1',
                         title: 'Opp Seperti nya lupa inputan berikut :',
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

                 }
             });
         });
     });


     // sellect 2
     $(document).ready(function() {
         $('.js-example-basic-single').select2({
             width: '100%'
         });
     });

 </script>
