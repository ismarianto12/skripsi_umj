<div class="card">
    <div class="card-header">
        <div class="card-title">Tambah Data tmjenisrap</div>
    </div>
    <div class="ket"></div>
    {{-- {} --}}
    <div class="alert alert-info"><i class="fa fa-edit"></i> Penginputan {{ $tanggal }}</div>
    <form id="exampleValidation" method="POST" class="simpan">
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-12">
                    <table class="table table-striped table-sm">
                        <tr>
                            <th> </th>
                            <th> </th>
                            <th>I</th>
                            <th>II</th>
                            <th>III</th>
                            <th>IV</th>
                        </tr>
                        <tr>
                            <th>Penawaran Telkomsel</th>
                            <th></th>
                            <th><input class="form-control number form-sm" name="penawaran_th_1" type="text"
                                    placeholder="1">
                            </th>
                            <th><input class="form-control number form-sm" name="penawaran_th_2" type="text"
                                    placeholder="2"></th>
                            <th><input class="form-control number form-sm" name="penawaran_th_3" type="text"
                                    placeholder="3"></th>
                            <th><input class="form-control number form-sm" name="penawaran_th_4" type="text"
                                    placeholder="4"></th>
                        </tr>
                        <tr>
                            <th>Pemilik Telkomsel</th>
                            <th></th>
                            <th><input class="form-control number form-sm" name="pemilik_1" type="text" placeholder="1">
                            </th>
                            <th><input class="form-control number form-sm" name="pemilik_2" type="text" placeholder="2">
                            </th>
                            <th><input class="form-control number form-sm" name="pemilik_3" type="text" placeholder="3">
                            </th>
                            <th><input class="form-control number form-sm" name="pemilik_4" type="text" placeholder="4">
                            </th>
                        </tr>

                    </table>

                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2">Penawaran harga Sewa</label>
                <div class="col-md-4">
                    <input type="text" name='penawaran_harga_sewa' class="number form-control" required />
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
                url: "{{ route('master.tmpsurat.store') }}",
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
