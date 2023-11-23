<div class="card">
    <div class="card-header">
        <div class="card-title">Input Rencana anggaran biaya proyek
        </div>
    </div>
    <div class="ket"></div>

    <form id="exampleValidation" method="POST" class="simpan">
        <div class="card-body">
            <div class="form-group row">
                <label for="name" class="col-md-2 text-left">Proyek<span class="required-label">*</span></label>
                <div class="col-md-4">
                    @php echo Properti_app::comboproyek() @endphp
                </div>


                {{-- <select class="js-example-basic-single form-control" name="tmbangunan_id"
                        id="tmbangunan_id">
                        @foreach ($bangunan as $listbangunan)
                            <option value="{{ $listbangunan->id }}">{{ $listbangunan->nama_bangunan }}</option>
                        @endforeach
                    </select> --}} <label for="name" class="col-md-2 text-left">Bangunan<span
                        class="required-label">*</span></label>
                <div class="col-md-4">
                    <div id="bangunan_data">
                    </div>

                </div>
            </div>

            <div class="form-group row">
                <label for="name" class="col-md-2 text-left">Jenis Rap<span class="required-label">*</span></label>
                <div class="col-md-4">
                    {{-- <input type="text" class="form-control" id="tmjenisrap_id" name="tmjenisrap_id"> --}}
                    <select class="js-example-basic-single form-control" name="tmjenisrap_id" id="tmbangunan_id">
                        @foreach ($tmjenisrap as $tnjenis)
                            <option value="{{ $tnjenis->id }}">{{ $tnjenis->kode_rap }}</option>
                        @endforeach
                    </select>
                </div>

                <label for="name" class="col-md-2 text-left">Pekerjaan <span class="required-label">*</span></label>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="pekerjaan" name="pekerjaan">
                </div>
            </div>
            <div class="form-group row">
                <label for="name" class="col-md-2 text-left">Volume <span class="required-label">*</span></label>
                <div class="col-md-4">
                    <input type="number" class="form-control" id="volume" name="volume">
                </div>

                <label for="name" class="col-md-2 text-left">Satuan <span class="required-label">*</span></label>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="satuan" name="satuan">
                </div>

            </div>
            <div class="form-group row">
                <label for="text" class="col-md-2 text-left">Harga Satuan <span class="required-label">*</span></label>
                <div class="col-md-4">
                    <input type="text" class="number_format form-control" id="harga_satuan" name="harga_satuan">
                </div>
            </div>
            <hr />
            <div class="form-group row">
                <label for="name" class="col-md-2 text-left">Total Jumlah harga <span
                        class="required-label">*</span></label>
                <div class="col-md-4">
                    &nbsp; &nbsp;
                    &nbsp;

                    <h4>
                        <div id="tharga"></div>
                    </h4>
                    <input type="hidden" id="jumlah_harga" name="jumlah_harga" readonly>
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

        // format number 
        $('.number_format').keyup(function(event) {
            // skip for arrow keys
            if (event.which >= 37 && event.which <= 40) return;
            // format number
            $(this).val(function(index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            });
        });

        function parseCurrency(num) {
            return parseFloat(num.replace(/,/g, ''));
        }
        // if get  input value in texboxt 
        $('input').keyup(function() {
            volume = parseCurrency($('input[name="volume"]').val());
            harga_satuan = parseCurrency($(
                'input[name="harga_satuan"]').val());
            nilai = volume * harga_satuan;
            $("#jumlah_harga").val(nilai);
            isNaN(nilai) ? 0 : $("#tharga").html(nilai.toLocaleString());

        });

    });

    $(function() {
        $('.simpan').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('master.tmrap.store') }}",
                method: "POST",
                data: $(this).serialize(),
                chace: false,
                async: false,
                success: function(data) {
                    $('select[name="tmproyek_id"]').val('');
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

        //search if that list 
        // $('#tmproyek_id').on('click', function(e) {
        //     $('#form_content').html(
        //         '<iframe src="{{ route('get.getproyek') }}" frameborder="0" style="width:100%; height:100%;"></iframe>'
        //     );
        // });
        // select data passed 
        id = $('select[name="tmproyek_id"]').val();
        $.post('{{ route('api.caribangunan') }}', {
            id: id,
        }, function(data) {
            passing = '';
            $.each(data, function(index, bangunan) {
                passing += "<option value=" + bangunan.id + ">" + bangunan
                    .nama_bangunan + "</option>";
            });
            $('#bangunan_data').html('<select name="tmbangunan_id" class="form-control">' +
                passing + '</select>');
        }, 'JSON').error(function() {
            alert('tidak ada response');
        });
        $('select[name="tmproyek_id"]').on('change', function(e) {
            e.preventDefault();
            id = $(this).val();
            $.post('{{ route('api.caribangunan') }}', {
                id: id,
            }, function(data) {
                passing = '';
                $.each(data, function(index, bangunan) {
                    passing += "<option value=" + data.id + ">" + bangunan
                        .nama_bangunan + "</option>";
                });
                $('#bangunan_data').html('<select name="tmbangunan_id" class="form-control">' +
                    passing + '</select>');
            }, 'JSON').error(function() {
                alert('tidak ada response');
            })
        })
    });
    // sellect 2
    $(document).ready(function() {
        $('.js-example-basic-single').select2({
            width: '100%'
        });
    });

</script>
{{-- list_model_proyek --}}
