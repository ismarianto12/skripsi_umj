<div class="card">
    <div class="card-header">
        <div class="card-title">Tambah Data tmjenisrap</div>
    </div>
    <div class="ket"></div>

    <form id="exampleValidation" method="POST" class="simpan">

        <div class="mb-3">
            <label for="unitId" class="form-label">Unit ID</label>
            <input type="text" class="form-control" id="unitId" name="unitId">
        </div>
        <div class="mb-3">
            <label for="kelasId" class="form-label">Kelas ID</label>
            <input type="text" class="form-control" id="kelasId" name="kelasId">
        </div>
        <div class="mb-3">
            <label for="kode" class="form-label">Kode</label>
            <input type="text" class="form-control" id="kode" name="kode">
        </div>
        <div class="mb-3">
            <label for="namaMapel" class="form-label">Nama Mapel</label>
            <input type="text" class="form-control" id="namaMapel" name="namaMapel">
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>


<script type="text/javascript">
    $(function() {
        $('.simpan').on('submit', function(e) {
            e.preventDefault();
            // alert('asa');
            $.ajax({
                url: "{{ route('master.tmjenisrap.update', $id) }}",
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
