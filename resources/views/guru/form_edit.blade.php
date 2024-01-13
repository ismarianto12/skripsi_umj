     <div class="card-header">
         <div class="card-title">Edit Data guru</div>
     </div>
     <div class="ket"></div>

     <form id="exampleValidation" method="POST" class="simpan" novalidate>
         <div class="form-group row">
             <label class="col-md-4 text-right">Nik</label>
             <div class="col-md-4">
                 <input name="nik" value="{{ $data->nik }}" class="form-control" disabled />
             </div>
         </div>
         <div class="form-group row">
             <label class="col-md-4 text-right">Nama</label>
             <div class="col-md-4">
                 <input name="nama" value="{{ $data->nama }}" class="form-control" />
             </div>
         </div>
         <div class="form-group row">
             <label class="col-md-4 text-right">Jenis kelamin</label>
             <div class="col-md-4">
                 <select class="form-control" id="jk" name="jk">
                     <option value="">- Jenis Kelamin -</option>
                     @foreach (Properti_app::JenisKel() as $jk => $val)
                         <option value="{{ $jk }}">{{ $val }}</option>
                     @endforeach
                 </select>
             </div>
         </div>
         <div class="form-group row">
             <label class="col-md-4 text-right">Tempat Lahir</label>
             <div class="col-md-4">
                 <input type="text" class="form-control" name="tempat_lahir" />
             </div>

         </div>
         <div class="form-group row">
             <label class="col-md-4 text-right">Tanggal Lahir</label>
             <div class="col-md-4">
                 <input type="date" class="form-control" name="ttl" value="{{ $data->ttl }}" />
             </div>
         </div>
         <div class="form-group row">
             <label class="col-md-4 text-right">Email</label>
             <div class="col-md-4">
                 <input name="email" value="{{ $data->email }}" class="form-control" />
             </div>
         </div>
         <div class="form-group row">
             <label class="col-md-4 text-right">password</label>
             <div class="col-md-4">
                 <input type="password" name="password" value="" class="form-control" />
             </div>
         </div>
         <div class="form-group row">
             <label class="col-md-4 text-right">Alamat</label>
             <div class="col-md-4">
                 <textarea class="form-control" name="alamat">{{ $data->alamat }}</textarea>
             </div>
         </div>
         <div class="form-group row">
             <label class="col-md-4 text-right">Telp.</label>
             <div class="col-md-4">
                 <input name="telp" value="{{ $data->telp }}" class="form-control" />
             </div>
         </div>


         <div class="form-group row">
             <label class="col-md-4 text-right">Inensif</label>
             <div class="col-md-4">
                 <input name="intensif" value="{{ $data->intensif }}" class="form-control" />
             </div>
         </div>
         <div class="form-group row">
             <label class="col-md-4 text-right">Jam mengajar</label>
             <div class="col-md-4">
                 <input name="jam_mengajar" value="{{ $data->jam_mengajar }}" class="form-control" />
             </div>
         </div>
         <div class="form-group row">
             <label class="col-md-4 text-right">Nominal jam</label>
             <div class="col-md-4">
                 <input name="nominal_jam" value="{{ $data->nominal_jam }}" class="form-control" />
             </div>
         </div>
         <div class="form-group row">
             <label class="col-md-4 text-right">Bpjs</label>
             <div class="col-md-4">
                 <input name="bpjs" value="{{ $data->bpjs }}" class="form-control" />
             </div>
         </div>
         <div class="form-group row">
             <label class="col-md-4 text-right">Koperasi</label>
             <div class="col-md-4">
                 <input name="koperasi" value="{{ $data->koperasi }}" class="form-control" />
             </div>
         </div>
         <div class="form-group row">
             <label class="col-md-4 text-right">Simpanan</label>
             <div class="col-md-4">
                 <input name="simpanan" value="{{ $data->simpanan }}" class="form-control" />
             </div>
         </div>
         <div class="form-group row">
             <label class="col-md-4 text-right">Tabungan</label>
             <div class="col-md-4">
                 <input name="tabungan" value="{{ $data->tabungan }}" class="form-control" />
             </div>
         </div>
         <div class="form-group row">
             <label class="col-md-4 text-right">Pendidikan</label>
             <div class="col-md-4">
                 <select class="form-control" name="pendidikan">
                     @foreach (Properti_app::jenjangApp() as $item => $val)
                         <option value="{{ $item }}">
                             {{ $val }}
                         </option>
                     @endforeach
                 </select>
             </div>
         </div>


         <div class="form-group row">
             <label class="col-md-4 text-right">status</label>
             <div class="col-md-4">

                 <select class="form-control" name="status">
                     @foreach (Properti_app::jenjangPeg() as $item => $val)
                         <option value="{{ $item }}">
                             {{ $val }}
                         </option>
                     @endforeach
                 </select>
             </div>
         </div>

         <div class="form-group row">
             <label class="col-md-4 text-right">Pendidikan</label>
             <div class="col-md-4">
                 <select class="form-control" name="pendidikan">
                     @foreach (Properti_app::jenjangApp() as $item => $val)
                         <option value="{{ $item }}">
                             {{ $val }}
                         </option>
                     @endforeach
                 </select>
             </div>
         </div>
         <div class="form-group row">
             <label class="col-md-4 text-right">status</label>
             <div class="col-md-4">
                 <select class="form-control" name="pendidikan">
                     @foreach (Properti_app::jenjangPeg() as $item => $val)
                         <option value="{{ $item }}">
                             {{ $val }}
                         </option>
                     @endforeach
                 </select>
             </div>
         </div>

         <div class="card-action">
             <div class="row">
                 <div class="col-md-12">
                     <input class="btn btn-success btn-sm" type="submit" value="Simpan">
                     <button class="btn btn-danger btn-sm" type="reset">Batal</button>
                 </div>
             </div>
     </form>


     <script type="text/javascript">
         $(function() {
             $('.simpan').on('submit', function(e) {
                 e.preventDefault();
                 $.ajax({
                     url: "{{ route('master.guru.update', $id) }}",
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
                         //  $('.ket').html(
                         //      "<div role='alert' class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>Perahtian donk!</strong> " +
                         //      respon.message + "<ol class='pl-3 m-0'>" + err + "</ol></div>");
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
                 })
             });
         });
     </script>
