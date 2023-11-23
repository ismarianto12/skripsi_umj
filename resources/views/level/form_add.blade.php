<div class="card">
    <div class="card-header">
        <div class="card-title">{{ _('Tambah Level Akses') }}</div>
    </div>
    <div class="ket"></div>
    <form id="exampleValidation" method="POST" class="simpan">

        <div class="card-body">

            <div class="form-group row">
                <label for="name" class="col-md-2 text-left">Kode Level<span class="required-label">*</span></label>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="level_kode" name="level_kode">
                </div>

                <label for="name" class="col-md-2 text-left">Nama level akses <span
                        class="required-label">*</span></label>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="level" name="level">
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
    $(function() {
        $('.simpan').on('submit', function(e) {
            e.preventDefault();
            // alert('asa');
            $.ajax({
                url: "{{ route('master.tmlevel.store') }}",
                method: "POST",
                data: $(this).serialize(),
                chace: false,
                async: false,
                success: function(data) {
                    $('#datatable').DataTable().ajax.reload();
                    $('#formmodal').modal('hide');

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


                }
            })
        });
    });
</script>
