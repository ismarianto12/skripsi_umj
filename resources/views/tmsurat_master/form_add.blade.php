<style>
    .form-control {
        font-size: 12px;
        border-color: #ebedf2;
        height: inherit !important;
    }

    table.display {
        margin: 0 auto;
        width: 100%;
        clear: both;
        border-collapse: collapse;
        table-layout: fixed; // add this
        word-wrap: break-word; // add this
    }
</style>

<script type="text/javascript">
    $(document).ready(function() {
        $('.number').keyup(function(event) {
            if (event.which >= 37 && event.which <= 40) return;
            // format number
            $(this).val(function(index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            });
        });
    });
</script>
<div class="card">
    <div class="card-header">
        <div class="card-title">{{ Properti_app::jenis_surat()[$jenis] }}</div>
    </div>
    <div class="ket"></div>
    <center>
        <table class="table-sm alert alert-danger" style="width: 30%;text-align: center;">
            <tr>
                <td>SITE ID
                    <br />
                    {{ isset($datanya->site_id) ? $datanya->site_id : '' }}
                </td>

                <td>Negosiator
                    <br />
                    {{ isset($datanya->nama_negosiator) ? $datanya->nama_negosiator : '' }}
                </td>
            </tr>
        </table>
    </center>
    <form id="exampleValidation" method="GET" class="simpan">
        @csrf
        <input type="hidden" name="jenis" readonly value="{{ $jenis }}" required />
        <input type="hidden" name="site_id" readonly value="{{ $site_id }}" required />
        @if ($jenis == 'BAK' or $jenis == 'BAN')
            <input type="hidden" name="tmp_id" readonly value="{{ $tmp_id }}" required />
        @endif
        <div class="card-body">
            @if ($jenis == 'SMR' or $jenis == 'BAN')
            @else
                <div class="form-group row">
                    <label class="col-md-2">Nomor surat</label>
                    <div class="col-md-4">
                        <input type="text" name="no_surat" value="{{ $no_surat }}" class="form-control" />
                    </div>
                </div>
            @endif
            @if ($jenis == 'SIP' || $jenis == 'SIT')
                <div class="form-group row">
                    <label class="col-md-2">Tanggal Surat</label>
                    <div class="col-md-4">
                        <input type="date" name='tgl_surat' value="{{ $tgl_surat }}" class="form-control"
                            required />
                    </div>
                </div>
            @elseif ($jenis == 'SPH')
                <div class="form-group row">
                    <label class="col-md-2">Tanggal Surat</label>
                    <div class="col-md-4">
                        <input type="date" name='tanggal_surat' value="{{ $tanggal_surat }}" class="form-control"
                            required />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2">Nomor Surat Landlord</label>
                    <div class="col-md-4">
                        <input type="text" name='nomor_surat_landlord' value="{{ $nomor_surat_landlord }}"
                            class="form-control" required />
                    </div>
                    <label class="col-md-2">Tanggal Surat Landlord</label>
                    <div class="col-md-4">
                        <input type="date" name='tanggal_surat_landlord' value="{{ $tanggal_surat_landlord }}"
                            class="form-control" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2">Perihal Surat Landlord</label>
                    <div class="col-md-4">
                        <small>* ) Silahkan entrikan data hanya berupa text dan spasi</small>
                        <input type="text" name='perihal_surat_landlord' class="form-control" required />
                    </div>
                    <label class="col-md-2">Penawaran Harga Sewa</label>
                    <div class="col-md-4">
                        <input type="text" name='penawaran_harga_sewa' value="{{ $penawaran_harga_sewa }}"
                            class="number form-control" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2">Periode Sewa Penawaran <br /> Awal</label>
                    <div class="col-md-4">
                        <input type="date" name='periode_sewa_penawaran_awal'
                            value="{{ $periode_sewa_penawaran_awal }} " class="form-control" required />
                    </div>

                    <label class="col-md-2">Periode Sewa Penawaran <br /> Akhir</label>
                    <div class="col-md-4">
                        <input type="date" name='periode_sewa_penawaran_akhir'
                            value="{{ $periode_sewa_penawaran_akhir }}" class="form-control" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2">Pic Landlord</label>
                    <div class="col-md-4">
                        <input type="text" name='pic_landlord' value="{{ $pic_landlord }}" class="form-control"
                            required />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2">Jabatan landlord</label>
                    <div class="col-md-4">
                        <input type="text" name='jabatan_landlord' value="{{ $jabatan_landlord }}"
                            class="form-control" required />
                    </div>
                </div>
            @elseif ($jenis == 'SMR')
                <div class="form-group row">
                    <label class="col-md-2">Harga sewa baru</label>
                    <div class="col-md-4">
                        <input type="text" name='harga_sewa_baru' value="{{ $harga_sewa_baru }}"
                            class="form-control number" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2">Periode Awal</label>
                    <div class="col-md-4">
                        <input type="date" name='periode_sewa_baru_d' value="{{ $periode_sewa_baru_d }}"
                            class="form-control" required />
                    </div>
                    <label class="col-md-2">Periode Akhir</label>
                    <div class="col-md-4">
                        <input type="date" name='periode_sewa_baru_sd' value="{{ $periode_sewa_baru_sd }}"
                            class="form-control" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2">Durasi Sewa</label>
                    <div class="col-md-4">
                        <textarea type="text" name="durasi_sewa" class="form-control">{{ isset($durasi_sewa) ? $durasi_sewa : '' }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2">Total Harga</label>
                    <div class="col-md-4">
                        <input type="text" name="total_harga_baru" class="number form-control"
                            value={{ isset($total_harga_baru) ? $total_harga_baru : '' }}>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <table class="table-sm alert alert-danger" style="width: 90%;text-align: center;">
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
                                <th><input class="number form-sm" name="penawaran_th_1"
                                        value="{{ $penawaran_th_1 }}" type="text" placeholder="1">
                                </th>
                                <th><input class="number form-sm" name="penawaran_th_2"
                                        value="{{ $penawaran_th_2 }}" type="text" placeholder="2"></th>
                                <th><input class="number form-sm" name="penawaran_th_3"
                                        value="{{ $penawaran_th_3 }}" type="text" placeholder="3"></th>
                                <th><input class="number form-sm" name="penawaran_th_4"
                                        value="{{ $penawaran_th_4 }}" type="text" placeholder="4"></th>
                            </tr>
                            <tr>
                                <th>Penawaran Pemilik </th>
                                <th></th>
                                <th><input class="number form-sm" name="pemilik_1" value="{{ $pemilik_1 }}"
                                        type="text" placeholder="1"></th>
                                <th><input class="number form-sm" name="pemilik_2" value="{{ $pemilik_2 }}"
                                        type="text" placeholder="2"></th>
                                <th><input class="number form-sm" name="pemilik_3" value="{{ $pemilik_3 }}"
                                        type="text" placeholder="3"></th>
                                <th><input class="number form-sm" name="pemilik_4" value="{{ $pemilik_4 }}"
                                        type="text" placeholder="4"></th>
                            </tr>
                        </table>
                    </div>
                </div>
            @elseif ($jenis == 'BAN')
                <div class="form-group row">
                    <label class="col-md-2">Tanggal Surat</label>
                    <div class="col-md-4">
                        <input type="date" name='tgl_surat' value="{{ $tgl_surat }}" class="form-control"
                            required />
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <table class="table-sm alert alert-danger" style="width: 90%;text-align: center;">
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
                                <th><input class="number form-sm" name="penawaran_th_1" readonly
                                        value="{{ $penawaran_th_1 }}" type="text" placeholder="1" readonly>
                                </th>
                                <th><input class="number form-sm" name="penawaran_th_2" readonly
                                        value="{{ $penawaran_th_2 }}" type="text" placeholder="2" readonly>
                                </th>
                                <th><input class="number form-sm" name="penawaran_th_3" readonly
                                        value="{{ $penawaran_th_3 }}" type="text" placeholder="3" readonly>
                                </th>
                                <th><input class="number form-sm" name="penawaran_th_4" readonly
                                        value="{{ $penawaran_th_4 }}" type="text" placeholder="4" readonly>
                                </th>
                            </tr>
                            <tr>
                                <th>Penawaran Pemilik </th>
                                <th></th>
                                <th><input class="number form-sm" name="pemilik_1" readonly
                                        value="{{ $pemilik_1 }}" type="text" placeholder="1" readonly></th>
                                <th><input class="number form-sm" name="pemilik_2" readonly
                                        value="{{ $pemilik_2 }}" type="text" placeholder="2" readonly></th>
                                <th><input class="number form-sm" name="pemilik_3" readonly
                                        value="{{ $pemilik_3 }}" type="text" placeholder="3" readonly></th>
                                <th><input class="number form-sm" name="pemilik_4" readonly
                                        value="{{ $pemilik_4 }}" type="text" placeholder="4" readonly></th>
                            </tr>

                        </table>

                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2">Harga sewa baru</label>
                    <div class="col-md-4">
                        <input type="text" name='harga_sewa_baru' readonly value="{{ $harga_sewa_baru }}"
                            class="form-control number" required />
                    </div>
                    <label class="col-md-2">Pengelola</label>
                    <div class="col-md-4">
                        <input type="text" name='pengelola' value="{{ $pengelola }}" class="form-control"
                            required />
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2">Nama pic</label>
                    <div class="col-md-4">
                        <input type="text" name='nama_pic' value="{{ $nama_pic }}" class="form-control"
                            required />
                    </div>
                    <label class="col-md-2">Alamat pic</label>
                    <div class="col-md-4">
                        <input type="text" name='alamat_pic' value="{{ $alamat_pic }}" class="form-control"
                            required />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2">Jabatan pic</label>
                    <div class="col-md-4">
                        <input type="text" name='jabatan_pic' value="{{ $jabatan_pic }}" class="form-control"
                            required />
                    </div>
                    <label class="col-md-2">Nomor telepon pic</label>
                    <div class="col-md-4">
                        <input type="text" name='nomor_telepon_pic' value="{{ $nomor_telepon_pic }}"
                            onkeypress="return /[0-9]/i.test(event.key)" class="form-control" required />
                    </div>
                </div>
            @elseif ($jenis == 'BAK')
                <div class="form-group row">
                    <label class="col-md-2">Lokasi tempat sewa</label>
                    <div class="col-md-4">
                        <input type="text" name='lokasi_tempat_sewa' value="{{ $lokasi_tempat_sewa }}"
                            class="form-control" required />
                    </div>
                    <label class="col-md-2">Luas tempat sewa</label>
                    <div class="col-md-4">
                        <input type="text" name='luas_tempat_sewa' value="{{ $luas_tempat_sewa }}"
                            class="form-control" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2">Nomor rekening</label>
                    <div class="col-md-4">
                        <input type="number" name='nomor_rekening' value="{{ $nomor_rekening }}"
                            class="form-control" required />
                    </div>
                    <label class="col-md-2">Pemilik rekening</label>
                    <div class="col-md-4">
                        <input type="text" name='pemilik_rekening' value="{{ $pemilik_rekening }}"
                            class="form-control" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2">Bank</label>
                    <div class="col-md-4">
                        <input type="text" name='bank' value="{{ $bank }}" class="form-control"
                            required />
                    </div>
                    <label class="col-md-2">Cabang</label>
                    <div class="col-md-4">
                        <input type="text" name='cabang' value="{{ $cabang }}"class="form-control"
                            required />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2">Nomor npwp</label>
                    <div class="col-md-4">
                        <input type="text" name='nomor_npwp' value="{{ $nomor_npwp }}" class="form-control"
                            required />
                    </div>
                    <label class="col-md-2">Pemilik npwp</label>
                    <div class="col-md-4">
                        <input type="text" name='pemilik_npwp' value="{{ $pemilik_npwp }}"
                            class="form-control" required />
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2">Harga Sewa Baru</label>
                    <div class="col-md-4">
                        <input type="text" name='harga_sewa_baru' readonly value="{{ $harga_sewa_baru }}"
                            class="form-control number" required />
                    </div>
                    <label class="col-md-2">Periode Awal </label>
                    <div class="col-md-4">
                        <input type="date" name='periode_awal' readonly value="{{ $periode_awal }}"
                            class="form-control" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2">Periode akkhir </label>
                    <div class="col-md-4">
                        <input type="date" name='periode_akhir' readonly value="{{ $periode_akhir }}"
                            class="form-control" required />
                    </div>
                    <label class="col-md-2">Alamat PIC </label>
                    <div class="col-md-4">
                        <textarea type="text" name='alamat_pic' class="form-control" readonly>{{ $alamat_pic }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2">Jabatan </label>
                    <div class="col-md-4">
                        <input type="text" name='jabatan_pic' readonly value="{{ $jabatan_pic }}"
                            class="form-control" required />
                    </div>
                    <label class="col-md-2">No. Telp PIC </label>
                    <div class="col-md-4">
                        <input type="number" name='no_telp_pic' readonly value="{{ $no_telp_pic }}"
                            class="form-control" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2">Pengelola </label>
                    <div class="col-md-4">
                        <input type="text" name='pengelola' readonly value="{{ $pengelola }}"
                            class="form-control" required />
                    </div>
                    <label class="col-md-2">Nama PIC </label>
                    <div class="col-md-4">
                        <input type="text" name='nama_pic' readonly value="{{ $nama_pic }}"
                            class="form-control" required />
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-md-2">Nomor SHM AJB HGB</label>
                    <div class="col-md-4">
                        <input type="text" name='nomor_shm_ajb_hgb' value="{{ $nomor_shm_ajb_hgb }}"
                            class="form-control" required />
                    </div>
                    <label class="col-md-2">Nomor IMB</label>
                    <div class="col-md-4">
                        <input type="text" onkeypress="return /[0-9]/i.test(event.key)" name='nomor_imb'
                            value="{{ $nomor_imb }}" class="form-control" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2">Nomor Sppt/ pbb</label>
                    <div class="col-md-4">
                        <input type="text" onkeypress="return /[0-9]/i.test(event.key)" name='nomor_sppt_pbb'
                            value="{{ $nomor_sppt_pbb }}" class="form-control" required />
                    </div>
                </div>
            @endif
            <div class="card-action">
                <div class="row">
                    <div class="col-md-12">

                        <button class="btn btn-info" type="submit"><i class="fa fa-print"></i>Print
                            preview</button>

                        <button class="btn btn-warning downloadlangsung" type="submit"><i
                                class="fa fa-download"></i>Download</button>
                    </div>
                </div>
            </div>
            {{-- @endif --}}
        </div>
    </form>

    {{-- @endif --}}
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('.js-example-basic-single').select2({
            width: '100%'
        });
    });
    $(function() {

        $('.downloadlangsung').on('click', function(e) {
            e.preventDefault();
            var parsed = $('.simpan').serialize();
            if ($('.form-control').val() == '') {
                swal.fire('info', 'Semua form wajib di isi', 'question');
            } else {
                $.ajax({
                    url: '{{ route('master.download') }}',
                    method: 'GET',
                    data: parsed,
                    dataType: 'JSON',
                    cache: false,
                    asynch: false,
                    success: function(jd) {
                        window.open(jd.filename);
                        $('#datatable').DataTable().ajax.reload();

                    }
                });
            }
            return false;
        });
        $('.simpan').on('submit', function(e) {
            e.preventDefault();
            var parsed = $(this).serialize();
            $.ajax({
                url: '{{ route('master.download') }}',
                method: 'GET',
                data: parsed,
                dataType: 'JSON',
                cache: false,
                asynch: false,
                success: function(jd) {

                    window.open(
                        'https://docs.google.com/gview?url=' + jd.filename +
                        '&embedded=true');
                    $('#datatable').DataTable().ajax.reload();

                },
                error: function(data) {
                    err = '';
                    respon = data.responseJSON;
                    $.each(respon.errors, function(index, value) {
                        err += "<li>" + value + "</li>";
                    });
                    swal.fire('info', err, 'Info');
                }

            });


        });
    });
    // add line


    /*
     
    author  : Triyadhi Surahman
    file    : npwp.js
    license : MIT
     
    serial number : check first 9 digit of NPWP
    kpp code : check 10th - 12th digit of NPWP
     
     
    based on:
    ---------
    http://www.npwponline.com/2016/03/cara-cek-npwp-online.html         (accessed 2017-09-14)
    https://drive.google.com/file/d/0B_v3TWJujICfVVJ5S3JDSUdVMGs/view   (accessed 2017-09-14)
    http://www.ortax.org/files/downaturan/15KMK03_389.pdf               (accessed 2017-09-14)
     
    notes:
    ------
    browser must support string as array, string.padStart(), string.subString(), string.indexOf()
     
    sample:
    -------
    var npwp = "012345674001000"
    var checknpwp = checkNPWP(npwp);
    var isvalidnpwp = isValidNPWP(npwp);
     
    2018-11-01
    ----------
    add KPP Pratama Jambi Pelayangan : 335
     
    2018-11-02
    ----------
    add KPP Pratama Balikpapan Barat : 729
     
    2018-11-05
    ----------
    add KPP Pratama Jombang : 649
     
    */

    // result -> object
</script>



{{-- src="https://docs.google.com/gview?url=https://www.adobe.com/support/ovation/ts/docs/ovation_test_show.ppt&embedded=true" --}}
