<div class="card">
    <div class="card-header">
        <div class="card-title">Tambah Proyek</div>
    </div>
    <div class="ket"></div>

    <form id="exampleValidation" method="POST" class="simpan">

        <div class="card-body">

            <div class="form-group row">
                <label for="name" class="col-md-2 text-left">Kode Proyek<span class="required-label">*</span></label>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="kode" name="kode">
                </div>

                <label for="name" class="col-md-2 text-left">Nama Proyek <span class="required-label">*</span></label>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="nama_proyek" name="nama_proyek">
                </div>
            </div>
            <div class="form-group row">

                <label for="name" class="col-md-2 text-left">Lokasi Proyek <span class="required-label">*</span></label>
                <div class="col-md-12">
                    <textarea class="form-control" name="lokasi" rows="6" cols="8"></textarea>
                </div>
            </div>
            <div class="form-group row">

                <label for="name" class="col-md-2 text-left">Tgl Mulai <br />Pengerjaan<span
                        class="required-label">*</span></label>
                <div class="col-md-4">
                    <input type="date" class="form-control" id="tgl_mulai" name="tgl_mulai">
                </div>

                <label for="name" class="col-md-2 text-left">Tgl Selesai Pengerjaan<span
                        class="required-label">*</span></label>
                <div class="col-md-4">
                    <input type="date" class="form-control" id="tgl_selesai" name="tgl_selesai">
                </div>
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
                url: "{{ route('master.tmproyek.store') }}",
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
