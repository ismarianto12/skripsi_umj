<div class="card">
    <div class="card-header">
        <div class="card-title">{{ _('Tambah Data Vendor') }}</div>
    </div>
    <div class="ket"></div>

    <form id="exampleValidation" method="POST" class="simpan">
        @csrf
        <div class="card-body">
            <div class="form-group row">
                <label for="name" class="col-md-2 text-left">Kode Vendor</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="kode" name="kode">
                </div>
                <label for="name" class="col-md-2 text-left">Nama vendor</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="nama" name="nama">
                </div>
            </div>
            <div class="form-group row">

                <label for="name" class="col-md-2 text-left">Npwp</label>
                <div class="col-md-4">
                    <input type="number" class="form-control" id="npwp" name="npwp">
                </div>
                <label for="name" class="col-md-2 text-left">Alamat</label>
                <div class="col-md-4">
                    <textarea class="form-control" id="alamat" name="alamat"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="name" class="col-md-2 text-left">No telp</label>
                <div class="col-md-4">
                    <input type="number" class="form-control" id="no_telp" name="no_telp">
                </div>
                <label for="name" class="col-md-2 text-left">Email </label>
                <div class="col-md-4">
                    <input type="email" class="form-control" id="email" name="email">
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
