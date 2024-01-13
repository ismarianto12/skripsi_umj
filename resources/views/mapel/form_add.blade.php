<div class="card">
    <div class="card-header">
        <div class="card-title">Tambah Data mapel</div>
    </div>
    <div class="ket"></div>

    <form id="exampleValidation" method="POST" class="simpan">
        <div class="form-group row">
            <label class="col-md-4 text-right">Kelas</label>
            <div class="col-md-4">
                <select class="form-control" name="kelas_id">
                    @foreach ($kelas as $kelas)
                        <option value="{{ $kelas->id }}">{{ $kelas->kelas }}</option>
                    @endforeach
                </select>
            </div>

        </div>
        <div class="form-group row">
            <label class="col-md-4 text-right">Kode </label>
            <div class="col-md-4">
                <input class="form-control" name="kode">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-4 text-right">Nam Mapel</label>
            <div class="col-md-4">
                <input class="form-control" name="nama_mapel">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-4 text-right">KKM</label>
            <div class="col-md-4">
                <input type="number" class="form-control" name="kkm">
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-success" type="submit">Simpan</button>
                <button class="btn btn-danger" type="reset">Batal</button>
            </div>
        </div>
    </form>
</div>


<script type="text/javascript">
    $(function() {
        $('.simpan').on('submit', function(e) {
            e.preventDefault();
            // alert('asa');
            $.ajax({
                url: "{{ route('master.mapel.store') }}",
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
