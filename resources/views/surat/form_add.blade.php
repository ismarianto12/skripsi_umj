<div class="card">
    <div class="card-header">
        <div class="card-title">{{ _('Tambah Data Surat') }}</div>
    </div>
    <div class="ket"></div>

    <form id="exampleValidation" method="POST" class="simpan">
        @csrf
        <div class="card-body">
            <div class="form-group row">
                <label class="col-md-3">JENIS SURAT</label>
                <div class="col-md-6">
                    {{-- <input type="text" name="jenis_surat_id" class="form-control" required /> --}}
                    <select name="jenis_surat_id" id="jenis_surat_id" class="form-control" required>
                        @foreach ($jenis_surat as $jenis)
                            <option value="{{ $jenis->id }}"> {{ $jenis->ket . '|' . $jenis->jenis }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3">SITE ID</label>
                <div class="col-md-6">
                    <input type="text" name="site_id" class="form-control" required />
                </div>
            </div>
            <div class="form-group row">

                <label class="col-md-3">SITE NAME</label>
                <div class="col-md-6">
                    <input type="text" name="site_name" class="form-control" required />
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3">NO PKS</label>
                <div class="col-md-6">
                    <input type="text" name="nomor_pks" class="form-control" required />
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3">ALAMAT SITE</label>
                <div class="col-md-6">
                    <input type="text" name="alamat_site" class="form-control" required />
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3">PIC PEMILIK LAHAN</label>
                <div class="col-md-6">
                    <input type="text" name="pic_pemilik_lahan" class="form-control" required />
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3">NILAI SEWA TAHUN</label>
                <div class="col-md-6">
                    <input type="text" name="nilai_sewa_tahun" class="form-control" required />
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3">PERIOD SEWA AWAL</label>
                <div class="col-md-6">
                    <input type="date" name="periode_sewa_awal" class="form-control" required />
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3">PERIODE SEWA AKHIR</label>
                <div class="col-md-6">
                    <input type="date" name="periode_sewa_akhir" class="form-control" required />
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3">NAMA NEGOSIATOR</label>
                <div class="col-md-6">
                    <input type="text" name="nama_negosiator" class="form-control" required />
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3">EMAIL NEGOSIATOR</label>
                <div class="col-md-6">
                    <input type="text" name="email_negosiator" class="form-control" required />
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3">NO HP NEGOSIATOR</label>
                <div class="col-md-6">
                    <input type="text" name="nomor_hp_negosiator" class="form-control" required />
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3">REVENE 3 BULAN</label>
                <div class="col-md-6">
                    <input type="text" name="revenue_3_bulan" class="form-control" required />
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3">REVENUE 2 BULAN</label>
                <div class="col-md-6">
                    <input type="text" name="revenue_2_bulan" class="form-control" required />
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3">REVENUE 1 BULAN</label>
                <div class="col-md-6">
                    <input type="text" name="revenue_1_bulan" class="form-control" required />
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3">HARGA PATOKAN</label>
                <div class="col-md-6">
                    <input type="text" name="harga_patokan" class="form-control" required />
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
    // sellect 2
    $(document).ready(function() {
        $('.js-example-basic-single').select2({
            width: '100%'
        });
    });
    $(function() {
        $('.simpan').on('submit', function(e) {
            e.preventDefault();
            // alert('asa');
            $.ajax({
                url: "{{ route('master.surat.store') }}",
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
