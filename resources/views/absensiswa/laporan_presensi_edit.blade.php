<div class="card-header">
    <div class="card-title">Edit Data Presensi || <b> {{ $data->siswa_nama }}</b>
    </div>
</div>
<div class="ket"></div>
<form id="exampleValidation" method="POST" class="simpan" novalidate>
    <div class="form-group row">
        <label class="col-md-4 text-right">Status Hadir {{ $data->status_hadir }}</label>
        <div class="col-md-4">
            <select class="form-control" name="status">
                @foreach (Properti_app::statusHadir() as $item => $val)
                    <option value="{{ $item }}" {{ $item === $data->status_hadir ? 'checked' : '' }}>
                        {{ $val }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="card-action">
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-info btn-sm" type="submit">Simpan</button>
                <button class="btn btn-danger btn-sm" type="reset">Batal</button>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">
    $(function() {
        $('.simpan').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('master.presensi_update', $id) }}",
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
