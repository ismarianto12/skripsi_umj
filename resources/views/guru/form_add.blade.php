<div class="card">
    <div class="card-header">
        <div class="card-title">Tambah Data guru</div>
    </div>
    <div class="ket"></div>

    <form id="exampleValidation" method="POST" class="simpan" novalidate>
        <div class="form-group row">
            <label class="col-md-4 text-right">ID Fingerprint</label>
            <div class="col-md-4">
                <input type="text" class="form-control" id="id_fingerprint" name="id_fingerprint" />
            </div>

        </div>
        <div class="form-group row">
            <label class="col-md-4 text-right">Nik</label>
            <div class="col-md-4">
                <input type="number" class="form-control" id="nik" name="nik">
            </div>

        </div>
        <div class="form-group row">
            <label class="col-md-4 text-right">Nama</label>
            <div class="col-md-4">
                <input type="text" class="form-control" id="nama" name="nama">
            </div>

        </div>
        <div class="form-group row">
            <label class="col-md-4 text-right">Jenis Kelamin</label>
            <div class="col-md-4">
                <select class="form-control" id="jk" name="jk">
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
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
                <input type="date" class="form-control" name="ttl" />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-4 text-right">Email</label>
            <div class="col-md-4">
                <input type="email" class="form-control" name="email" />
            </div>

        </div>
        <div class="form-group row">
            <label class="col-md-4 text-right">Password</label>
            <div class="col-md-4">
                <input type="password" class="form-control" name="password" />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-4 text-right">Alamat Lengkap</label>
            <div class="col-md-4">
                <textarea name="alamat_lengkap" class="form-control"></textarea>
            </div>

        </div>
        <div class="form-group row">
            <label class="col-md-4 text-right">Telp</label>
            <div class="col-md-4">
                <input type="number" class="form-control" name="" />
            </div>

        </div>
        <div class="form-group row">
            <label class="col-md-4 text-right">Divisi</label>
            <div class="col-md-4">
                <input type="text" class="form-control" name="" />
            </div>

        </div>

        <div class="form-group row">
            <label class="col-md-4 text-right">Jam mengajar</label>
            <div class="col-md-4">
                <input type="text" class="form-control" name="jam_mengajar" />
            </div>

        </div>
        <div class="form-group row">
            <label class="col-md-4 text-right">Nominal jam</label>
            <div class="col-md-4">
                <input type="text" class="form-control" name="nominal_jam" />
            </div>

        </div>
        <div class="form-group row">
            <label class="col-md-4 text-right">Bpjs</label>
            <div class="col-md-4">
                <input type="text" class="form-control" name="bpjs" />
            </div>

        </div>
        <div class="form-group row">
            <label class="col-md-4 text-right">Koperasi</label>
            <div class="col-md-4">
                <input type="text" class="form-control" name="koperasi" />
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
                    <input class="btn btn-success" type="submit" value="Simpan">
                    <button class="btn btn-danger" type="reset">Batal</button>
                </div>
            </div>
        </div>
    </form>
</div>


<script type="text/javascript">
    $(function() {
        $('.simpan').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('master.guru.store') }}",
                method: "POST",
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
