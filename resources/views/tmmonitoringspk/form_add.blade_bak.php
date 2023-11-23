<!-- no_spk
tmpspk_id
tmprogres_spk_id
periode_awal
periode_akhir
spk_harga_progres
spk_bayar_lalu
spk_bayar_sekarang
spk_bayar_tot
spk_byr_sisa_lalu
spk_bayar_sisa_skrg
spk_byr_sisa_total
  -->


<div class="card">
    <div class="card-header">
        <div class="card-title">{{ _('Monitoring surat Perintah Kerja') }}</div>
    </div>
    <div class="ket"></div>
    <form id="exampleValidation" method="POST" class="simpan">
        <div class="card-body">
            <div class="form-group row">

                <label for="name" class="col-md-2 text-left">
                    Periode awal
                </label>

                <div class="col-md-4">
                    <input type="date" class="form-control" name='periode_awal'>
                </div>
                <label for="name" class="col-md-2 text-left">
                    Periode akhir
                </label>

                <div class="col-md-4">
                    <input type="date" class="form-control" name='periode_akhir'>
                </div>
            </div>
            <div class="form-group row">
                <label for="name" class="col-md-2 text-left">
                    Surat Perintah <br />Kerja
                </label>
                @php
                    // dd($tmrspk);
                @endphp
                <div class="col-md-4">
                    <select class="js-example-basic-single form-control" name="tmrspk_id" id="tmrspk_id">
                        <option value="">--Pilih Surat --</option>
                        @foreach ($tmrspk as $f => $list)
                            <option value="{{ $list->id }}" nilai_hrg="{{ $list->tot_spk }}">
                                {{ $list->no_spk }} -
                                {{ $list->nama_proyek != '' ? $list->nama_proyek : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <label for="name" class="col-md-2 text-left">
                    Nomor SPK
                </label>

                <div class="col-md-4">
                    <input type="text" class="form-control" name='no_spk' id="no_spk">
                </div>
            </div>

            <div class="form-group row">
                <label for="name" class="col-md-2 text-left">
                    Spk harga progres
                </label>
                <div class="col-md-4">
                    <input type="text" class="number_format form-control" name='spk_harga_progres'>
                </div>
                <label for="name" class="col-md-2 text-left">
                    Spk bayar lalu
                </label>

                <div class="col-md-4">
                    <input type="text" class="number_format form-control" name='spk_bayar_lalu'>
                </div>
            </div>
            <div class="form-group row">
                <label for="name" class="col-md-2 text-left">
                    Spk bayar <br /> sekarang
                </label>
                <div class="col-md-4">
                    <input type="text" class="number_format form-control" name='spk_bayar_sekarang'>
                </div>

                <label for="name" class="col-md-2 text-left">
                    Spk bayar total
                </label>
                <div class="col-md-4">
                    <input type="text" class="number_format form-control" name='spk_bayar_tot' value="0" readonly>
                </div>
            </div>
            <div class="form-group row">

                <label for="name" class="number_format col-md-2 text-left">
                    Spk bayar sisa lalu
                </label>
                <div class="col-md-4">
                    <input type="text" class="number_format form-control" name='spk_byr_sisa_lalu'>
                </div>

                <label for="name" class="number_format col-md-2 text-left">
                    Spk bayar <br /> Sisa sekarang
                </label>
                <div class="col-md-4">
                    <input type="text" class="number_format form-control" name='spk_bayar_sisa_skrg'>
                </div>
            </div>
            <div class="form-group row">
                <label for="name" class="number_format col-md-2 text-left">
                    SPK Bayar <br /> Sisa Total
                </label>
                <div class="col-md-4">
                    <input type="text" class="number_format form-control" name='spk_byr_sisa_total'>
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
        $('#tmrspk_id').on('change', function() {
            // alert($(this).val());
            id = $(this).val();
            periode_awal = $('input[name="periode_awal"]').val();
            periode_akhir = $('input[name="periode_akhir"]').val();

            if (periode_awal == '' || periode_akhir == '') {
                Swal.fire('kesalahan', 'tanggal periode awal dan periode akhir tidak boleh kosong',
                    'error');
                $('select[name="tmrspk_id"]').val("");
            } else {
                $.ajax({
                    url: '{{ route('api.searchspk') }}',
                    data: {
                        id: id
                    },
                    method: 'post',
                    dataType: "Json",
                    chace: false,
                    success: function(data) {
                        if (Object.keys(data).length == 0) {
                            Swal.fire('Data kosong',
                                'data yang di cari tidak ada, silahkan periksa kembali pencarian anda.',
                                'info');
                            $('select[name="tmrspk_id"]').val('');
                            $('input[name="periode_awal"]').val('');
                            $('input[name="periode_akhir"]').val('');

                            $('input').val('');
                        } else {
                            // //  get result 
                            $('input[name="spk_bayar_lalu"]').val(data.spk_harga_sisa).attr(
                                'readonly',
                                true);

                            $('input[name="no_spk"]').val(data.no_spk).attr(
                                'readonly',
                                true);
                            $('input[name="spk_harga_progres"]').val(
                                    currency(data
                                        .spk_harga_progres))
                                .attr(
                                    'readonly', true);

                            $('input[name="spk_byr_sisa_lalu"]').val(
                                    currency(data
                                        .spk_progress_lalu))
                                .attr(
                                    'readonly', true);
                            $('input[name="spk_byr_sisa_total"]').val(
                                    currency(
                                        data
                                        .spk_harga_sisa))
                                .attr(
                                    'readonly', true);
                            $('input[name="spk_bayar_tot"]').val(
                                    data.spk_jumlah_harga)
                                .attr(
                                    'readonly', true);
                        }
                    },
                    error: function(Jqxhr, error) {

                    }

                })

            }

        });

        $('input').keyup(function() {
            $('input[name="spk_bayar_sisa_skrg"]').attr('readonly',
                true);
            // jumlahkan nilai
            spk_harga_progres = parseCurrency($('input[name="spk_harga_progres"]').val());

            spk_byr_sisa_total = parseCurrency($('input[name="spk_byr_sisa_total"]').val());
            spk_bayar_tot = parseCurrency($('input[name="spk_bayar_tot"]').val());
            // get val inputan 
            spk_bayar_sekarang = parseCurrency($('input[name="spk_bayar_sekarang"]').val());
            spk_byr_sisa_lalu = parseCurrency($('input[name="spk_byr_sisa_lalu"]').val());
            // hitung nilai spk;
            nilai_spk = parseInt(spk_bayar_sekarang + spk_byr_sisa_lalu);
            totalcount = spk_byr_sisa_total - nilai_spk;
            rspk_bayar_sisa_skrg = parseInt(totalcount - spk_byr_sisa_lalu)
            // get value
            $('input[name="spk_bayar_tot"]').val(currency(totalcount)).attr('readonly', true);
            $('input[name="spk_bayar_sisa_skrg"]').val(currency(rspk_bayar_sisa_skrg)).attr('readonly',
                true);

        });


    });


    $(function() {
        $('.simpan').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('master.monitoringspk.store') }}",
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

    // sellect 2
    $(document).ready(function() {
        $('.js-example-basic-single').select2({
            width: '100%'
        });
    });

</script>
