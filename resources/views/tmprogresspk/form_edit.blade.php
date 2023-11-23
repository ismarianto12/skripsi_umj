<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<div class="card">
    <div class="card-header">
        <div class="card-title">{{ _('Monitoring Pembayaran SPK Add Edit
            ') }}</div>
    </div>
    <div class="ket"></div>
    <form id="exampleValidation" method="POST" class="simpan">
        <div class="card-body">

            <div class="form-group row">


                <label for="name" class="col-md-2 text-left">Periode Awal</label>
                <div class="col-md-4">
                    <input type="date" class="form-control" name="periode_awal" value="{{ $periode_awal }}">
                </div>
                <label for="name" class="col-md-2 text-left">Periode Akhir</label>
                <div class="col-md-4">
                    <input type="date" class="form-control" name="periode_akhir" value="{{ $periode_akhir }}">
                </div>

            </div>
            <div class="form-group row">

                <label for="name" class="col-md-2 text-left">Surat Perintah <br />Kerja</label>
                <div class="col-md-4">
                    @php
                        // dd($tmrspk);
                    @endphp
                    <select class="js-example-basic-single form-control" name="tmrspk_id" id="tmrspk_id">
                        <option value="0">--Pilih Surat --</option>
                        @foreach ($tmrspk as $f => $list)
                            @php
                                $selected = $list->id == $tmrspk_id ? 'selected' : '';
                            @endphp
                            <option value="{{ $list->id }}" nilai_hrg="{{ $list->tot_spk }}" {{ $selected }}>
                                {{ $list->no_spk }} -
                                {{ $list->nama_proyek != '' ? $list->nama_proyek : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <label for="name" class="col-md-2 text-left">Spk Harga Progres</label>
                <div class="col-md-4">
                    <input type="text" class="number_format form-control" name="spk_harga_progres"
                        value="{{ $spk_harga_progres }}">
                </div>
            </div>
            <div class="form-group row">

                <label for="name" class="col-md-2 text-left">Spk Progres <br />Sekarang</label>
                <div class="col-md-4">
                    <input type="number" class="form-control" name="spk_progress_skg" style="
                    width: 30%;
                    display: inline;
                " value="{{ $spk_progress_skg }}"> %
                </div>
                <label for="name" class="col-md-2 text-left">Spk Progress Total</label>
                <div class="col-md-4">
                    <input type="hidden" name="spk_progress_tot">
                    <input type="text" class="number_format form-control" name="gspk_progress_tot" readonly style="
                    width: 30%;
                    display: inline;
                " value="{{ $spk_progress_tot }}"> %
                </div>

            </div>
            <div class="form-group row">

                <label for="name" class="col-md-2 text-left">Spk Progres Lalu</label>
                <div class="col-md-4">
                    <input type="number" class="form-control" name="spk_progress_lalu" style="
                    width: 30%;
                    display: inline;
                " value="{{ $spk_progress_lalu }}" readonly> %
                </div>

                <div class="col-md-4">
                    <input type="hidden" name="spk_harga_sisa" value="{{ $spk_harga_sisa }}">
                    <h2 style="color: red">{{ __('SPK Harga Sisa :') }} <div class="tspk_harga_sisa">
                            {{ number_format($spk_harga_sisa, 2) }}</div>
                    </h2>
                </div>
            </div>
            <div class="form-group row">
                <label for="name" class="col-md-2 text-left">Total Harga SPK
                </label>
                <div class="col-md-4">
                    <input type="text" class="number_format form-control" name="spk_harga_total">
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
        $('input').keyup(function() {
            // get total spk is  


            spk_progress_lalu = $('input[name="spk_progress_lalu"]').val();
            spk_progress_skrg = $('input[name="spk_progress_skg"]').val();

            tot_spkprog = (parseInt(spk_progress_skrg) + parseInt(spk_progress_lalu));
            $("input[name='spk_progress_tot']").val(tot_spkprog);
            $("input[name='gspk_progress_tot']").val(tot_spkprog);
            // isNaN(nilai) ? 0 : $("#tspk").html(nilai.toLocaleString());
            if ($('input[name="rspk_harga_total"]').val() != '') {
                harga_total = parseCurrency($('input[name="rspk_harga_total"]').val());
                spk_harga_progres = parseCurrency($('input[name="spk_harga_progres"]').val());

                total_pers = (100 - tot_spkprog) / 100;

                totalcount = harga_total * total_pers;
                totspk_harga_progres = harga_total * (spk_progress_skrg / 100);

                console.log(total_pers + 'ini adalah harga progress');
                console.log(totalcount);
                $('input[name="spk_harga_progres"]').val(totspk_harga_progres.toLocaleString());
                $('input[name="spk_harga_sisa"]').val(totalcount);
                $('.tspk_harga_sisa').html(totalcount.toLocaleString());

                $('input[name="spk_harga_sisa"]').val(parseCurrency(totalcount));
            } else {
                swal.fire(
                    'Error',
                    'silahkan pilih no surat kerja terlebih dahulu',
                    'error'
                );
            }

        });
        // if change function  
        // alert('sss');
        var val_id_fr = '{{ $tmrspk_id }}';
        if (val_id_fr != '') {
            $.post('{{ route('api.trspk_detail') }}', {
                    id: val_id_fr
                }, function(data) {
                    $('input[name="spk_harga_total"]').val(data);
                    $('input[name="rspk_harga_total"]').val(data);

                    $('input[name="rspk_harga_total"]').attr('readonly', true);
                    $('input[name="spk_harga_total"]').attr('readonly', true);
                }, 'JSON')
                .fail(function() {
                    alert("error");
                });
        }
        // get parent before
        var val_id_fr = $(this).val();
        if (val_id_fr != '') {
            $.post('{{ route('api.getparentspk') }}', {
                    tmrspk_id: val_id_fr
                }, function(data) {
                    progrestot = (data.spk_progress_tot) ? data.spk_progress_tot : 0;
                    $('input[name="spk_progress_lalu"]').val(progrestot).attr('readonly', true);
                }, 'JSON')
                .fail(function() {
                    swal.fire('cannot', 'cant response page server error', 'error');
                });
        }


        // add data if counting selected


        $('select[name="tmrspk_id"]').on('change', function() {
            // alert('sss');
            var val_id = $(this).val();
            if (val_id != '') {
                $.post('{{ route('api.trspk_detail') }}', {
                        id: val_id
                    }, function(data) {
                        $('input[name="spk_harga_total"]').val(data);
                        $('input[name="rspk_harga_total"]').val(data);

                        $('input[name="rspk_harga_total"]').attr('readonly', true);
                        $('input[name="spk_harga_total"]').attr('readonly', true);
                    }, 'JSON')
                    .fail(function() {
                        alert("error");
                    });
            }
            // get parent before
            var val_id = $(this).val();
            if (val_id != '') {
                $.post('{{ route('api.getparentspk') }}', {
                        tmrspk_id: val_id
                    }, function(data) {
                        progreslalu = (data.plalu) ? data.plalu : 0;
                        $('input[name="spk_progress_lalu"]').val(progreslalu);
                    }, 'JSON')
                    .fail(function() {
                        swal.fire('cannot', 'cant response page server error', 'error');
                    });
            }

        });

    });

    $(function() {
        $('.simpan').on('submit', function(e) {
            e.preventDefault();
            if (tot_spkprog > 100) {
                $.alert('error', 'Gagal Spk melebih persetase yang salah');
            } else {
                $.ajax({
                    url: "{{ route('master.tmprogresspk.update', $id) }}",
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
                });
            }
        });
    });

    // sellect 2
    $(document).ready(function() {
        $('.js-example-basic-single').select2({
            width: '100%'
        });
    });

</script>
