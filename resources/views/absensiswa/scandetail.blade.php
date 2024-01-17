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
                                        {{ $jadwal->guru_pengampu }}
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        Jumlah Siswa
                                    </td>

                                    <td>
                                        {{ $jadwal->jumlah_siswa }} Orang
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
                            <div class="presensi_button">
                                <div class="col-md-12 text-center">
                                    <button class="btn btn-danger batal_presensi"><i class="fas fa-times"></i> Batal
                                        Presensi</button>
                                    &nbsp;&nbsp;

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
            // function kembali() {
            //     $.pjax({
            //         container: '#pjax-container', // ID dari kontainer yang akan di-refresh
            //         url: '{{ Url('master/scan') }}', // URL yang akan dimuat secara dinamis
            //         push: false // Menonaktifkan perubahan URL di baris alamat
            //     });
            // }

            $('.batal_presensi').on('click', function() {
                Swal.fire({
                    title: "Anda Yakin? ",
                    text: "Batalkan Presensi akan menghapus semua presensi yang berjalan",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ok"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.pjax({
                            container: '#pjax-container', // ID dari kontainer yang akan di-refresh
                            url: '{{ Url('master/scan') }}', // URL yang akan dimuat secara dinamis
                            push: false // Menonaktifkan perubahan URL di baris alamat
                        });

                    }
                })
            })



            document.title = 'tst';
            $('.page-title').html('');
            // $('.nav-item').html(render_mapel);
            $('.mape_render').html('');
            $('.pertemnua_render').html('');
            $('.kelas_render').html('');
            $('#preview').html('<h4>Loading Aplikasi</h4>');
            const constraints = {
                video: {
                    facingMode: 'environment'
                }
            };

            navigator.mediaDevices.getUserMedia(constraints)
                .then((stream) => {
                    scanner.video.srcObject = stream;
                    scanner.start();
                })
                .catch((error) => {
                    console.error('Error accessing camera:', error);
                });

            let scanner = new Instascan.Scanner({
                video: document.getElementById(
                    'preview')
            });

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

            scanner.addListener('scan', function(content) {
                let data = content;
                let dataArray = data.split('|');
                let nama = dataArray[2];
                let kelas = dataArray[1];
                let id_siswa = dataArray[3];


                if (nama === undefined) {
                    Swal.fire('Error',
                        'Siswa Tidak TerSimpan',
                        'error');
                } else {
                    Swal.fire('Hadir', `${nama} <br />Kelas : ${localStorage.getItem('kelas')}`, 'success');

                    var varkelas_id = localStorage
                        .getItem(
                            'kelasdata');

                    $.ajax({
                        url: '{{ Url('/api/saveabsen') }}',
                        type: 'POST',
                        data: {
                            id_siswa: id_siswa,
                            pertemua: '{{ $jadwal->pertemuan }}',
                            jadwal_id: '{{ $jadwal->jadwal_id }}',
                            guru_id: '{{ $jadwal->guru_id }}',
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
                                text: xhr.responseText,
                                icon: 'error'
                            });
                            // Lakukan hal lain setelah terjadi error jika perlu
                        },
                    });
                }
            });

        });
    </script>
@endsection
