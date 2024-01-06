<style>
    /* Aturan umum untuk kedua jenis perangkat */
    /* Misalnya, warna latar belakang umum */
    body {
        background-color: #f4f4f4;
    }

    /* Aturan khusus untuk perangkat mobile */
    @media screen and (max-width: 767px) {
        video {
            width: 100%;
        }
    }

    /* Aturan khusus untuk perangkat desktop */
    @media screen and (min-width: 768px) {
        video {
            width: 100% !important;
        }

    }
</style>

@extends('layouts.template')
@section('content')
    @include('layouts.breadcum')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
            </div>
            <div class="card-body _apprender">


                <div class="container">
                    <div class="row">
                        <div class="col-md-3 render_ubah">
                            <div class="form-group">
                                <label for="kelas" class="col-form-label">Pilih Kelas :</label>
                                <select class="form-control" id="datakelas" name="datakelas">
                                    <option value="">- Semua data -</option>
                                    @foreach ($kelas as $kelasdata)
                                        <option value="{{ $kelasdata->kelas }}">{{ $kelasdata->kelas }} -
                                            [{{ $kelasdata->tingkat }}]</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 render_ubah">
                            <div class="form-group">
                                <label for="render_mapel" class="col-form-label">Pilih Mata Pelajaran :</label>
                                <select class="form-control" id="render_mapel" name="render_mapel">
                                    <option value="">- Semua data -</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 render_ubah">
                            <div class="form-group">
                                <label for="pertemuan" class="col-form-label">Pertemuan Ke :</label>
                                <select class="form-control" id="pertemuan" name="pertemuan">
                                    <option value="">- Semua data -</option>
                                    @php
                                        $i = 16;
                                    @endphp

                                    @foreach (range(1, $i) as $value)
                                        <option value="{{ $value }}">{{ $value }}</option>
                                        @php
                                            $i++;
                                        @endphp
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <br /><br />

                                <button class="btn btn-primary setup_presensi_"><i class="fa fa-start"></i> Settup
                                    Presensi</button>
                            </div>
                        </div>
                    </div>
                    <br />

                    <p>Untuk jadwal disusun oleh bagian akademik sekolah / tata usaha</p>
                    <br />
                    <div class="render_page"></div><br />
                    <br />

                </div>

                <div class="col-md-12 row render_presensi_dom">

                    <div class="col-md-6">




                        <video id="preview" style="width: 100%;">Camera Loading Please Wait.... </video>
                        <small>Pastikan Posisi QR Menghadap Kamera</small>
                    </div>
                    <div class="col-md-6">
                        <div class="alert alert-warning">
                            Guru Mata Pelajaran - Drs. SOBARI
                            Jumlah Siswa : 22 , Hadir : 12
                        </div>
                        <div class="card card-body">
                            <table>
                                <tr>
                                    <th>Mata Pelajaran</th>
                                    <td>:</td>
                                    <td class="right-align mape_render"></td>
                                </tr>
                                <tr>
                                    <th>Siswa</th>
                                    <td>:</td>
                                    <td class="right-align render_siswa">Loading ....</td>
                                </tr>
                                <tr>
                                    <th>Kelas</th>
                                    <td>:</td>

                                    <td class="right-align kelas_render"></td>
                                </tr>
                                <tr>
                                    <th>Pertemuan ke</th>
                                    <td>:</td>

                                    <td class="right-align pertemnua_render"></td>
                                </tr>
                                <tr>
                                    <th>Status </th>
                                    <td>:</td>
                                    <td class="right-align render_hadir"></td>
                                </tr>
                            </table>
                            <div class="container">
                                <div class="form-group row justify-content-between">
                                    <br>
                                    <button class="btn btn-danger batal_presensi"><i class="fas fa-times"></i> Batal
                                        Presensi</button>
                                    &nbsp;&nbsp;
                                    <button class="btn btn-primary simpan_presensi"><i class="fas fa-save"></i> Simpan
                                        Presensi</button>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

    <script type="text/javascript">
        document.title = 'Setup Presensis';

        $(function() {
            $('#floating-button').hide();
            $('.batal_presensi').hide();
            $('.simpan_presensi').hide();

            $('.render_presensi_dom').hide();

            $('select[name="datakelas"]').on('change', function() {
                var kelas_id = $(this).val();
                if (kelas_id != '') {
                    $.post('{{ Url('master/mapeldata') }}', {
                                kelas_id: kelas_id
                            },
                            function(data) {
                                option = '<option value="">Pilih Mapta Pelajaran.</option>';
                                $.each(data, function(index, value) {
                                    option += "<option value='" + value.id + "'>" +
                                        value
                                        .nama_mapel + "</option>";
                                });
                                $('#render_mapel').html(option);
                            }, 'JSON')
                        .fail(function() {
                            swal.fire('cannot', 'can\'er  getd get data mapel', 'error');
                        });
                }
            });
            $('.setup_presensi_').on('click', function() {
                Swal.fire({
                    title: "Anda yakin presensi akan di setup?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {

                        $('.render_presensi_dom').show();
                        $('.simpan_presensi').show();
                        $('.batal_presensi').show();
                        $('.render_ubah').hide();
                        $('.setup_presensi_').hide();

                        var kelas_id = $('#datakelas option:selected').val();
                        var render_mapel = $('#render_mapel option:selected').text();
                        var pertemuan = $('#pertemuan option:selected').val();
                        document.title = render_mapel;

                        $('.page-title').html(render_mapel);
                        // $('.nav-item').html(render_mapel);

                        $('.mape_render').html(render_mapel);
                        $('.pertemnua_render').html(pertemuan);
                        $('.kelas_render').html(kelas_id);
                        $('#preview').html('<h4>Loading Aplikasi</h4>');
                        let scanner = new Instascan.Scanner({
                            video: document.getElementById('preview')
                        });

                        scanner.addListener('scan', function(content) {
                            let data = content;
                            let dataArray = data.split('|');
                            let nama = dataArray[2];
                            let kelas = dataArray[1];
                            if (nama != '' || nama == undefined) {
                                $('.render_siswa').html(`<b>${nama}</b>`);
                                $('.render_hadir').html(`<b>Hadir</b>`);
                            } else {
                                Swal.fire('Error', 'Siswa Tidak Terdaftar', 'error');
                            }

                        });
                        Instascan.Camera.getCameras().then(function(cameras) {
                            if (cameras.length > 0) {
                                scanner.start(cameras[0]);
                            } else {
                                console.error('No cameras found.');
                            }
                        }).catch(function(e) {
                            console.error(e);
                        });

                    }
                });
            })

            $('.batal_presensi').on('click', function() {
                Swal.fire({
                    title: "Batalkan Presensi",
                    text: "Anda Yakin? ",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire('Success', "berhasil di batalkan", 'success')
                        $.pjax.reload('#pjax-container');
                    }
                })
            })
        });
    </script>
@endsection
