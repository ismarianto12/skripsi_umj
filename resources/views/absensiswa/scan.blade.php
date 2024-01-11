<style>
    /* Aturan umum untuk kedua jenis perangkat */
    /* Misalnya, warna latar belakang umum */
    body {
        background-color: #f4f4f4;
    }

    .presensi_button {
        background: #ddd;
        right: 0;
        left: 0;
        position: fixed;
        bottom: 0;
        z-index: 999;
        width: 100%;
        margin: 0 auto;
    }

    /* Aturan khusus untuk perangkat mobile */
    @media screen and (max-width: 767px) {
        table {
            font-size: 10.5px !important;
        }

        video {
            width: 100%;
        }
    }

    /* Aturan khusus untuk perangkat desktop */
    @media screen and (min-width: 768px) {
        table {
            font-size: 14px !important;
        }

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
                <div class="container _contn__">
                    <form id="setup_presensi_" class="needs-validation" novalidate>

                        <div class="row __aklsdalmda">
                            <div class="col-md-3 render_ubah">
                                <div class="form-group">
                                    <label for="kelas" class="col-form-label">Pilih Kelas :</label>
                                    <select class="form-control" id="datakelas" name="datakelas" required>
                                        <option value="">- Semua data -</option>
                                        @foreach ($kelas as $kelasdata)
                                            <option value="{{ $kelasdata->kelas }}">{{ $kelasdata->kelas }} -
                                                [{{ $kelasdata->tingkat }}]</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Please provide a name.
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-3 render_ubah">
                                <div class="form-group">
                                    <label for="render_mapel" class="col-form-label">Pilih Mata Pelajaran :</label>
                                    <select class="form-control" id="render_mapel" name="render_mapel" required>
                                        <option value="">- Semua data -</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please provide a name.
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-3 render_ubah">
                                <div class="form-group">
                                    <label for="pertemuan" class="col-form-label">Pertemuan Ke :</label>
                                    <select class="form-control" id="pertemuan" name="pertemuan" required>
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
                                    <div class="invalid-feedback">
                                        Please provide a name.
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <br /><br />
                                    <button type="submit" class="btn btn-primary btn-md"><i class="fa fa-save"></i>
                                        Setup Jadwal</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <br />

                    <p>Untuk jadwal disusun oleh bagian akademik sekolah / tata usaha</p>
                    <br />
                    <div class="render_page"></div><br />
                    <br />

                </div>

                <div class="col-md-12 row render_presensi_dom">

                    <div class="col-md-6">




                        <video id="preview" style="width: 100%;">Camera Loading Please Wait.... </video>
                        <small style="
                        font-size: 10px;
                    ">Pastikan Posisi QR
                            Menghadap Kamera</small>
                        <br />
                    </div>
                    <div class="col-md-6">
                        <div class="alert alert-warning">
                            <table>
                                <tr>
                                    <td>
                                        Guru Pengampu
                                    </td>

                                    <td>
                                        Drs. SOBARI
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        Jumlah Siswa
                                    </td>

                                    <td>
                                        <div id="getSiswa"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td> Hadir</td>
                                    <td>
                                        <div id="total_hadir"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tidak Hadir</td>
                                    <td>

                                        <div id="tidak_hadir"></div>
                                    </td>
                                </tr>
                            </table>
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
                            <div class="presensi_button">
                                <div class="col-md-12 text-center">
                                    <button class="btn btn-danger batal_presensi"><i class="fas fa-times"></i> Batal
                                        Presensi</button>
                                    &nbsp;&nbsp;
                                    <button class="btn btn-primary simpan_presensi"><i class="fas fa-save"></i> Simpan
                                        Presensi</button>
                                </div>
                                <br />
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        document.title = 'Setup Presensis';
        $(function() {
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
            $('#setup_presensi_').on('submit', function(event) {
                event.preventDefault();
                var form = $(this);
                if (form[0].checkValidity() === false) {
                    // $('.invalid')
                    event.stopPropagation();
                } else {


                    Swal.fire({
                        title: "Anda yakin presensi akan di setup?",
                        text: "You won't be able to revert this!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Ok"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var kelas_id = $('#datakelas option:selected')
                                .val();
                            localStorage.setItem('kelasdata', kelas_id);
                            var render_mapel = $(
                                    '#render_mapel option:selected')
                                .text();
                            var pertemuan = $('#pertemuan option:selected')
                                .val();

                            $.ajax({
                                url: '{{ Url('/api/simpanjadwal') }}',
                                type: 'POST',
                                data: {
                                    kelas_id: kelas_id,
                                    jumlah_siswa: '0',
                                    sesi: pertemuan,
                                    pertemuan: pertemuan,
                                    user_id: '{{ Auth::user()->id }}'
                                },
                                beforeSend: function() {
                                    Swal.fire({
                                        title: 'Please Wait...',
                                        allowOutsideClick: false,
                                        showCancelButton: false,
                                        showConfirmButton: false,
                                    });
                                    Swal.showLoading();
                                },
                                success: function(response) {
                                    Swal.close();
                                    Instascan.Camera.getCameras().then(function(
                                        cameras) {
                                        if (cameras.length > 0) {
                                            scanner.start(cameras[0]);
                                        } else {
                                            console.error('No cameras found.');
                                        }
                                    }).catch(function(e) {
                                        console.error(e);
                                    });
                                    $('._contn__').hide();
                                    $('.__aklsdalmda').hide();
                                    $('.page-inner').hide();
                                    $('.render_presensi_dom').show();
                                    $('.simpan_presensi').show();
                                    $('.batal_presensi').show();
                                    $('.render_ubah').hide();
                                    $('.setup_presensi_').hide();

                                    document.title = render_mapel;
                                    $('.page-title').html(render_mapel);
                                    // $('.nav-item').html(render_mapel);
                                    $('.mape_render').html(render_mapel);
                                    $('.pertemnua_render').html(pertemuan);
                                    $('.kelas_render').html(kelas_id);
                                    $('#preview').html('<h4>Loading Aplikasi</h4>');
                                    let scanner = new Instascan.Scanner({
                                        video: document.getElementById(
                                            'preview')
                                    });

                                    scanner.addListener('scan', function(content) {
                                        let data = content;
                                        let dataArray = data.split('|');
                                        let nama = dataArray[2];
                                        let kelas = dataArray[1];
                                        let id_siswa = dataArray[3];
                                        if (nama === undefined) {
                                            Swal.fire('Error',
                                                'Siswa Tidak Terdaftar',
                                                'error');
                                        } else {
                                            console.log(data, 'idsiswanya');
                                            var varkelas_id = localStorage
                                                .getItem(
                                                    'kelasdata');
                                            console.log(varkelas_id,
                                                'localstorage')
                                            console.log(parseInt(kelas) !==
                                                parseInt(
                                                    varkelas_id),
                                                'kelas')
                                            var pertemuan = $(
                                                '#pertemuan option:selected'
                                            )
                                            $.ajax({
                                                url: '{{ Url('/api/saveabsen') }}',
                                                type: 'POST',
                                                data: {
                                                    id_siswa: id_siswa,
                                                    pertemua: pertemuan,
                                                    jadwal_id: 1,
                                                    guru_id: '{{ Auth::user()->id }}',
                                                    status: '1',
                                                    user_id: '{{ Auth::user()->id }}'
                                                },
                                                beforeSend: function() {
                                                    Swal
                                                        .showLoading();
                                                    Swal.fire(
                                                        'Info',
                                                        'Please wait ...',
                                                        'info');
                                                },
                                                success: function(
                                                    response) {
                                                    Swal.fire(
                                                        'Hadir',
                                                        `${nama} <br /> Kelas ${kelas}`,
                                                        'success'
                                                    );
                                                    $('.render_siswa')
                                                        .html(
                                                            `<b>${nama}</b>`
                                                        );
                                                    $('.render_hadir')
                                                        .html(
                                                            `<b>Hadir</b>`
                                                        );
                                                },
                                                error: function(xhr,
                                                    status,
                                                    error) {
                                                    Swal.fire({
                                                        title: 'Error',
                                                        text: 'An error occurred while saving data.',
                                                        icon: 'error'
                                                    });
                                                    // Lakukan hal lain setelah terjadi error jika perlu
                                                },
                                            });
                                        }
                                    });
                                },
                                error: function(xhr, status,
                                    error) {
                                    Swal.fire({
                                        title: 'Error',
                                        text: 'An error occurred while saving data.',
                                        icon: 'error'
                                    });
                                    // Lakukan hal lain setelah terjadi error jika perlu
                                },
                            });






                        }
                    });
                }
            })


            $('.simpan_presensi').on('click', function() {
                Swal.fire({
                    title: "Simpan Presensi",
                    text: "Anda Yakin?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ok"
                }).then((result) => {
                    if (result.isConfirmed) {
                        const yourData = '';
                        $.ajax({
                            url: '{{ Url('/api/saveabsen') }}',
                            type: 'POST',
                            data: yourData,
                            beforeSend: function() {
                                Swal.showLoading();
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: 'Success',
                                    text: 'Data saved successfully!',
                                    icon: 'success'
                                });
                            },
                            error: function(xhr, status, error) {
                                Swal.fire({
                                    title: 'Error',
                                    text: 'An error occurred while saving data.',
                                    icon: 'error'
                                });
                                // Lakukan hal lain setelah terjadi error jika perlu
                            },
                            complete: function() {
                                // Menutup SweetAlert setelah proses selesai (baik sukses maupun error)
                                Swal.close();
                            }
                        });

                    }
                })
            })


            $('.batal_presensi').on('click', function() {
                Swal.fire({
                    title: "Batalkan Presensi",
                    text: "Anda Yakin? ",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ok"
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire('Success', "berhasil di batalkan", 'success')
                        $.pjax.reload('#pjax-container')
                    }
                })
            })
        });
    </script>
@endsection
