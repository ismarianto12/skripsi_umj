<div class="card">
    <div class="card-header">
        <div class="card-title">Tambah Data guru</div>
    </div>
    <div class="ket"></div>

    <form id="exampleValidation" method="POST" class="simpan">
        <div class="form-group row">
            <label class="col-md-4">ID Fingerprint</label>
            <div class="col-md-4">
                <input type="text" class="form-control" name="id_fingerprint" />
            </div>

        </div>
        <div class="form-group row">
            <label class="col-md-4">Nik</label>
            <div class="col-md-4">
                <input type="number" class="form-control" id="nik" name="nik">
            </div>

        </div>
        <div class="form-group row">
            <label class="col-md-4">Nama</label>
            <div class="col-md-4">
                <input type="text" class="form-control" id="nama" name="nama">
            </div>

        </div>
        <div class="form-group row">
            <label class="col-md-4">Jenis Kelamin</label>
            <div class="col-md-4">
                <select class="form-control" id="jk" name="jk">
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>

        </div>
        <div class="form-group row">
            <label class="col-md-4">Tempat Tanggal Lahir</label>
            <div class="col-md-4">
                <input type="text" class="form-control" name="" />
            </div>

        </div>
        <div class="form-group row">
            <label class="col-md-4">Email</label>
            <div class="col-md-4">
                <input type="text" class="form-control" name="" />
            </div>

        </div>
        <div class="form-group row">
            <label class="col-md-4">Password</label>
            <div class="col-md-4">
                <input type="text" class="form-control" name="" />
            </div>

        </div>
        <div class="form-group row">
            <label class="col-md-4">Alamat Lengkap</label>
            <div class="col-md-4">
                <input type="text" class="form-control" name="" />
            </div>

        </div>
        <div class="form-group row">
            <label class="col-md-4">Telp</label>
            <div class="col-md-4">
                <input type="number" class="form-control" name="" />
            </div>

        </div>
        <div class="form-group row">
            <label class="col-md-4">Divisi</label>
            <div class="col-md-4">
                <input type="text" class="form-control" name="" />
            </div>

        </div>
        <div class="form-group row">
            <label class="col-md-4">dept</label>
            <div class="col-md-4">
                <input type="text" class="form-control" name="" />
            </div>

        </div>
        <div class="form-group row">
            <label class="col-md-4">Intensif</label>
            <div class="col-md-4">
                <input type="text" class="form-control" name="" />
            </div>

        </div>
        <div class="form-group row">
            <label class="col-md-4">Jam mengajar</label>
            <div class="col-md-4">
                <input type="text" class="form-control" name="jam_mengajar" />
            </div>

        </div>
        <div class="form-group row">
            <label class="col-md-4">Nominal jam</label>
            <div class="col-md-4">
                <input type="text" class="form-control" name="nominal_jam" />
            </div>

        </div>
        <div class="form-group row">
            <label class="col-md-4">Bpjs</label>
            <div class="col-md-4">
                <input type="text" class="form-control" name="" />
            </div>

        </div>
        <div class="form-group row">
            <label class="col-md-4">Koperasi</label>
            <div class="col-md-4">
                <input type="text" class="form-control" name="koperasi" />
            </div>

        </div>


        <div class="form-group row">
            <label class="col-md-4">id_pend</label>
            <div class="col-md-4">
                <input type="text" class="form-control" name="id_pend" />
            </div>

        </div>
        <div class="form-group row">
            <label class="col-md-4">kode_reff</label>
            <div class="col-md-4">
                <input type="text" class="form-control" name="kode_reff" />
            </div>

        </div>
        <div class="form-group row">
            <label class="col-md-4">jumlah_reff</label>
            <div class="col-md-4">
                <input type="text" class="form-control" name="jumlah_reff" />
            </div>

        </div>
        <div class="form-group row">
            <label class="col-md-4">role_id</label>
            <div class="col-md-4">
                <input type="text" class="form-control" name="role_id" />
            </div>

        </div>
        <div class="form-group row">
            <label class="col-md-4">status</label>
            <div class="col-md-4">
                <input type="text" class="form-control" name="status" />
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
