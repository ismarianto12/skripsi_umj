@extends('layouts.template')
@section('content')
    @include('layouts.breadcum')
    <div class="col-md-12">
        <div class="card">
            <div id="hasil_render"></div>
            <div id="video-container" style="margin: 0 auto">
                <video id="qr-video" style="width: 100%"></video>
            </div>

            {{-- <div class="col-md-12 row">
                <div class="col-md-5">
                    <label>
                        Highlight Style
                        <select class="form-control" id="scan-region-highlight-style-select">
                            <option value="default-style">Default style</option>
                            <option value="example-style-1">Example custom style 1</option>
                            <option value="example-style-2">Example custom style 2</option>
                        </select>
                    </label>
                    <!-- <label>
                                            <input id="show-scan-region" type="checkbox">
                                            Show scan region canvas
                                        </label> -->
                </div>
                <div class="col-md-5">
                    <select class="form-control" id="inversion-mode-select">
                        <option value="original">Scan original (dark QR code on bright background)</option>
                        <option value="invert">Scan with inverted colors (bright QR code on dark background)</option>
                        <option value="both">Scan both</option>
                    </select>
                    <br>
                </div>
            </div> --}}
            <div class="container mt-4">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cam-list"><b>Preferred camera:</b></label>
                            <select id="cam-list" class="form-control">
                                <option value="environment" selected>Environment Facing (default)</option>
                                <option value="user">User Facing</option>
                            </select>
                        </div>

                        {{-- <div class="form-group">
                            <label><b>Camera has flash: </b></label>
                            <span id="cam-has-flash"></span>
                        </div> --}}

                        <div class="form-group">
                            <button id="flash-toggle" class="btn btn-primary">📸 Flash: <span
                                    id="flash-state">off</span></button>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cam-qr-result"><b>Siswa Yang Di Scan</b></label>
                            <span id="cam-qr-result">None</span>
                        </div>

                        <div class="form-group">
                            <label for="cam-qr-result-timestamp"><b>Scan Terakhir </b></label>
                            <span id="cam-qr-result-timestamp"></span>
                        </div>

                        {{-- <div class="form-group row">
                            <button id="stop-button" class="batal_presensi btn btn-danger btn-sm"
                                style="width: 50%">Stop</button>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(function() {

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
                        window.location.href = '{{ Url('master/scan') }}';
                    }
                })
            })
        })
    </script>

    <script type="module">
        import QrScanner from "https://nimiq.github.io/qr-scanner/qr-scanner.min.js";

        const video = document.getElementById('qr-video');
        const videoContainer = document.getElementById('video-container');
        // const camHasCamera = document.getElementById('cam-has-camera');
        const camList = document.getElementById('cam-list');
        const camHasFlash = document.getElementById('cam-has-flash');
        const flashToggle = document.getElementById('flash-toggle');
        const flashState = document.getElementById('flash-state');
        const camQrResult = document.getElementById('cam-qr-result');
        const camQrResultTimestamp = document.getElementById('cam-qr-result-timestamp');
        const fileSelector = document.getElementById('file-selector');
        const fileQrResult = document.getElementById('file-qr-result');


        const scanner = new QrScanner(video, result => setResult(camQrResult, result), {
            onDecodeError: error => {
                camQrResult.textContent = error;
                camQrResult.style.color = 'inherit';
            },
            highlightScanRegion: true,
            highlightCodeOutline: true,
        });


        let jumlah = 1;

        function setResult(label, result) {
            console.log(result.data);
            let data = result.data;
            let dataArray = data.split('|');
            let nama = dataArray[2];
            let id_siswa = dataArray[1];
            let kelas = dataArray[3];

            console.log(dataArray, 'detail get')
            localStorage.setItem("getid_siswa", id_siswa);
            if (parseInt(getid_siswa) === parseInt(id_siswa)) {
                console.log(jumlah, 'jumlah_scandata_par');
            }

            if (nama === undefined) {
                Swal.fire('Error',
                    'QR bukan Kartu Siswa',
                    'error');
            } else {

                $(`#hasil_render`).html(`
                        <div style="text-align: center;margin-top: 26px;">
                                ${nama}
                                Hadir
                             <h1>Success </h1>
                             <br />
                             </div>
                            `)
                $('.render_siswa')
                    .html(
                        `<b>${nama}</b>`
                    );
                $('.render_hadir')
                    .html(
                        `<b>Hadir</b>`
                    );
                var getid_siswa = localStorage.getItem("getid_siswa");
                console.log(parseInt(getid_siswa) !== parseInt(id_siswa), 'logic main app')

                // if (parseInt(getid_siswa) !== parseInt(id_siswa)) {
                var varkelas_id = localStorage
                    .getItem(
                        'kelasdata');

                $.ajax({
                    url: '{{ Url('/api/saveabsen') }}',
                    type: 'POST',
                    data: {
                        id_siswa: id_siswa,
                        pertemuan: '{{ $jadwal->pertemuan }}',
                        jadwal_id: '{{ $jadwal->jadwal_id }}',
                        guru_id: '{{ $jadwal->guru_id }}',
                        status: '1',
                        user_id: '{{ Auth::user()->id }}'
                    },
                    success: function(
                        response) {


                    },
                    error: function(xhr,
                        status,
                        error) {

                        // Lakukan hal lain setelah terjadi error jika perlu
                    },
                });
                // }
            }

            label.innerHTML = '<div class="alert alert-info"> Hadir : ' + result.data + "</div>";
            camQrResultTimestamp.textContent = new Date().toString();
            label.style.color = 'teal';
            clearTimeout(label.highlightTimeout);
            label.highlightTimeout = setTimeout(() => {
                label.innerHTML = ''; // Menghapus konten setelah beberapa waktu
                label.style.color = 'inherit';
            }, 100);

            jumlah++;

        }


        // const updateFlashAvailability = () => {
        //     scanner.hasFlash().then(hasFlash => {
        //         camHasFlash.textContent = hasFlash;
        //         flashToggle.style.display = hasFlash ? 'inline-block' : 'none';
        //     });
        // };

        // scanner.start().then(() => {
        //     updateFlashAvailability();
        //     QrScanner.listCameras(true).then(cameras => cameras.forEach(camera => {
        //         const option = document.createElement('option');
        //         option.value = camera.id;
        //         option.text = camera.label;
        //         camList.add(option);
        //     }));
        // });

        // QrScanner.hasCamera().then(hasCamera => camHasCamera.textContent = hasCamera);

        // for debugging
        // window.scanner = scanner;

        // document.getElementById('scan-region-highlight-style-select').addEventListener('change', (e) => {
        //     videoContainer.className = e.target.value;
        //     scanner._updateOverlay(); // reposition the highlight because style 2 sets position: relative
        // });

        // document.getElementById('show-scan-region').addEventListener('change', (e) => {
        //     const input = e.target;
        //     const label = input.parentNode;
        //     label.parentNode.insertBefore(scanner.$canvas, label.nextSibling);
        //     scanner.$canvas.style.display = input.checked ? 'block' : 'none';
        // });

        // document.getElementById('inversion-mode-select').addEventListener('change', event => {
        //     scanner.setInversionMode(event.target.value);
        // });
        scanner.start();
        camList.addEventListener('change', event => {
            scanner.setCamera(event.target.value).then(updateFlashAvailability);
        });

        flashToggle.addEventListener('click', () => {
            scanner.toggleFlash().then(() => flashState.textContent = scanner.isFlashOn() ? 'on' : 'off');
        });

        // document.getElementById('start-button').addEventListener('click', () => {


        // });

        // document.getElementById('stop-button').addEventListener('click', () => {
        //     scanner.stop();
        // });

        // ####### File Scanning #######

        // fileSelector.addEventListener('change', event => {
        //     const file = fileSelector.files[0];
        //     if (!file) {
        //         return;
        //     }
        //     QrScanner.scanImage(file, {
        //             returnDetailedScanResult: true
        //         })
        //         .then(result => setResult(fileQrResult, result))
        //         .catch(e => setResult(fileQrResult, {
        //             data: e || 'No QR code found.'
        //         }));
        // });
    </script>

    <style>
        div {
            margin-bottom: 16px;
        }

        #video-container {
            line-height: 0;
        }

        #video-container.example-style-1 .scan-region-highlight-svg,
        #video-container.example-style-1 .code-outline-highlight {
            stroke: #64a2f3 !important;
        }

        #video-container.example-style-2 {
            position: relative;
            width: max-content;
            height: max-content;
            overflow: hidden;
        }

        #video-container.example-style-2 .scan-region-highlight {
            border-radius: 30px;
            outline: rgba(0, 0, 0, .25) solid 50vmax;
        }

        #video-container.example-style-2 .scan-region-highlight-svg {
            display: none;
        }

        #video-container.example-style-2 .code-outline-highlight {
            stroke: rgba(255, 255, 255, .5) !important;
            stroke-width: 15 !important;
            stroke-dasharray: none !important;
        }

        #flash-toggle {
            display: none;
        }

        hr {
            margin-top: 32px;
        }

        input[type="file"] {
            display: block;
            margin-bottom: 16px;
        }
    </style>
@endsection
