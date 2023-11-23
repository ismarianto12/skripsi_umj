<div class="card">
    <div class="card-header">
        <div class="card-title">{{ _('Surat Perintah Kerja
            Action Edit') }}</div>
    </div>
    <div class="ket"></div>
    <form id="exampleValidation" method="POST" class="simpan">
        <div class="form-group row">
            <label for="name" class="col-md-2 text-left">Pilih <br />Pekerjaan Rap</label>
            <div class="col-md-4">
                <input type="hidden" name="tmjenisrap_id" id="tmjenisrap_id">
                <select class="js-example-basic-single form-control" name="tmrap_id" id="tmrap_id">
                    <option value=""></option>
                    @foreach ($tmrapdatas as $ld => $tmrapdata)
                        @php
                            $selected = $tmrapdata->id_rap == $tmrap_id ? 'selected' : '';
                        @endphp
                        <option value="{{ $tmrapdata->id_rap }}" {{ $selected }}> {{ $tmrapdata->tanggal }}
                        </option>
                    @endforeach
                </select>
            </div>

            <label for="name" class="col-md-2 text-left">Vendor </label>
            <div class="col-md-4">
                <select class="js-example-basic-single form-control" name="trvendor_id" id="trvendor_id">
                    @foreach ($trvendor as $vendor)
                        <option value="{{ $vendor->id }}">{{ $vendor->nama }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="name" class="col-md-2 text-left">No SPK</label>
            <div class="col-md-4">
                <input type="text" class="form-control" id="no_spk" name="no_spk" value="{{ $no_spk }}">
            </div>
            <label for="name" class="col-md-2 text-left">Jenis Rap</label>
            <div class="col-md-4">
                <input type="text" class="form-control" id="jenis_rap" name="jenis_rap" readonly>
            </div>
        </div>
        <div class="form-group row">
            <label for="name" class="col-md-2 text-left">Pekerjaan</label>
            <div class="col-md-4">
                <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" value="{{ $pekerjaan }}"
                    readonly>
            </div>
            <label for="name" class="col-md-2 text-left">Volume</label>
            <div class="col-md-4">
                <input type="hidden" id="volume" name="volume">
                <input type="text" class="form-control" id="volume_rspk" name="volume_rspk" value="{{ $volume }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="name" class="col-md-2 text-left"> Satuan</label>
            <div class="col-md-4">
                <input type="text" class="number_format form-control" id="satuan" name="satuan"
                    value="{{ $satuan }}">
            </div>
            <label for="name" class="col-md-2 text-left">Harga Satuan</label>
            <div class="col-md-4">
                <input type="text" class="number_format form-control" id="spk_harga_satuan" name="spk_harga_satuan"
                    value="{{ number_format($spk_harga_satuan, 2) }}" readonly>
            </div>
        </div>


        <div class="form-group row">
            <label for="name" class="col-md-2 text-left">Jumlah Harga SPK</label>
            <div class="col-md-4">
                <input type="hidden" id="spk_jumlah_harga" name="spk_jumlah_harga" value="{{ $spk_jumlah_harga }}"
                    readonly>
            </div>
            <hr />
            <div style="clearfix"></div>
            <h2>Total :<div id="tspk"></div>
            </h2>
        </div>

        <div class="card-action">
            <div class="row">
                <div class="col-md-12">
                    <input class="btn btn-success" type="submit" value="Simpan">
                    <button class="btn btn-danger" type="reset">Batal</button>
                </div>
            </div>
        </div>

</div>
</form>
</div>


<script type="text/javascript">
    $(document).ready(function() {
        $('.number_format').keyup(function(event) {
            if (event.which >= 37 && event.which <= 40) return;
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
            volume_rspk = parseCurrency($('input[name="volume_rspk"]').val());

            if (volume_rspk > volume) {
                Swal.fire(
                    'kesalahan',
                    'Besaran nilai volume tidak boleh lebih dari nilai spk.',
                    'error',
                );
            }
            spk_harga_satuan = parseCurrency($(
                '#spk_harga_satuan').val());
            nilai = volume_rspk * spk_harga_satuan;
            $("#spk_jumlah_harga").val(nilai);
            isNaN(nilai) ? 0 : $("#tspk").html(nilai.toLocaleString());
        });

    });

    function formatnumber(n, dp) {
        var s = '' + (Math.floor(n)),
            d = n % 1,
            i = s.length,
            r = '';
        while ((i -= 3) > 0) {
            r = ',' + s.substr(i, 3) + r;
        }
        return s.substr(0, i + 3) + r + (d ? '.' + Math.round(d * Math.pow(10, dp || 2)) : '');
    }

    $(function() {
        $('.simpan').on('submit', function(e) {
            if (volume_rspk > volume) {
                Swal.fire(
                    'kesalahan',
                    'Besaran nilai volume tidak boleh lebih dari nilai spk.',
                    'error',
                );
            } else {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('master.tmrspk.update', $id) }}",
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
            }
        });


    });

    // sellect 2
    $(document).ready(function() {
        $('.js-example-basic-single').select2({
            width: '100%'
        });

        // if edit only this action
        var id = "{{ $tmrap_id }}";
        $.post('{{ route('report.searchrap') }}', {
            tmrap_id: id,
        }, function(data) {
            $('#jenis_rap').val((data.nama_rap) ? data.nama_rap : 'kosong').attr(
                'readonly', true);
            $('#tmjenisrap_id').val((data.tmjenisrap_id) ? data.tmjenisrap_id : 'kosong')
                .attr(
                    'readonly', true);
            $('#pekerjaan').val((data.pekerjaan) ? data.pekerjaan : 'kosong').attr(
                'readonly', true);
            $('#volume').val((data.volume) ? data.volume : 'kosong').attr('readonly', true);

            $('#satuan').val((data.satuan) ? data.satuan : 'kosong').attr('readonly', true);
            $('#spk_harga_satuan').val((data.harga_satuan) ? formatnumber(data
                        .harga_satuan) :
                    'kosong')
                .attr('readonly', true);

            $('#spk_jumlah_harga').val((data.jumlah_harga) ? formatnumber(data
                        .jumlah_harga) :
                    'kosong')
                .attr('readonly', true);
            $('#tspk').html(formatnumber(data.jumlah_harga));

        }, 'JSON').error(function() {
            Swal.fire('danger', 'server not response', 'error');
        });
        // select data response from backendd 
        $('#tmrap_id').on('change', function(e) {
            e.preventDefault();
            var newid = $(this).val();
            $.post('{{ route('report.searchrap') }}', {
                tmrap_id: newid,
            }, function(data) {
                $('#jenis_rap').val((data.nama_rap) ? data.nama_rap : 'kosong').attr(
                    'readonly', true);
                $('#tmjenisrap_id').val((data.tmjenisrap_id) ? data.tmjenisrap_id : 'kosong')
                    .attr(
                        'readonly', true);

                $('#pekerjaan').val((data.pekerjaan) ? data.pekerjaan : 'kosong').attr(
                    'readonly', true);
                $('#volume').val((data.volume) ? data.volume : 0);
                $('#volume_rspk').val((data.volume) ? data.volume : 0);

                $('#satuan').val((data.satuan) ? data.satuan : 'kosong').attr('readonly', true);
                $('#spk_harga_satuan').val((data.harga_satuan) ? formatnumber(data
                            .harga_satuan) :
                        'kosong')
                    .attr('readonly', true);

                $('#spk_jumlah_harga').val((data.jumlah_harga) ? formatnumber(data
                            .jumlah_harga) :
                        'kosong')
                    .attr('readonly', true);
                $('#spk_jumlah_harga').val((data.jumlah_harga) ? formatnumber(data
                            .jumlah_harga) :
                        'kosong')
                    .attr('readonly', true);
                $('#tspk').html(formatnumber(data.jumlah_harga));

            }, 'JSON').error(function() {
                Swal.fire('danger', 'server not response', 'error');
            })
        });


    });

</script>
