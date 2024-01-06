@extends('layouts.template')

@section('content')
    <style>
        table,
        td,
        th {

            padding: 10px 15px 10px;
        }

        table {
            width: 90%;
            border-collapse: collapse;
        }

        .highcharts-title {
            font-family: 'Arial'
        }

        table {
            border-collapse: collapse;
            font-size: 25px;
        }

        .border_bottom {
            /* border-right: 1px solid #ddd; */
            text-align: center;
            border-color: red
        }

        .border_top {
            border-right: 1px solid #ddd;
            text-align: center;
            width: auto;
            border-top: 1px solid #ddd;
        }
    </style>
    <br /><br />

    <div class="page-inner">
        <h4 class="page-title">Dashboard Panel</h4> 
        <div class="row"> 
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center">
                                    <i class="flaticon-chart-pie text-warning"></i>
                                </div>
                            </div>
                            <div class="col-7 col-stats">
                                <div class="numbers">
                                    <p class="card-category">Number</p>
                                    <h4 class="card-title">150GB</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center">
                                    <i class="flaticon-coins text-success"></i>
                                </div>
                            </div>
                            <div class="col-7 col-stats">
                                <div class="numbers">
                                    <p class="card-category">Revenue</p>
                                    <h4 class="card-title">$ 1,345</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center">
                                    <i class="flaticon-error text-danger"></i>
                                </div>
                            </div>
                            <div class="col-7 col-stats">
                                <div class="numbers">
                                    <p class="card-category">Errors</p>
                                    <h4 class="card-title">23</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center">
                                    <i class="flaticon-twitter text-primary"></i>
                                </div>
                            </div>
                            <div class="col-7 col-stats">
                                <div class="numbers">
                                    <p class="card-category">Followers</p>
                                    <h4 class="card-title">+45K</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 row">

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div id="container"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div id="barg"></div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script>
        Highcharts.chart('barg', {
            title: {
                text: 'Grafik Kemajuan Belajar Siswa', // Judul grafik
                style: {
                    fontSize: '18px' // Ukuran teks judul
                }
            },
            subtitle: {
                text: 'Data Penjualan dalam Satuan Juta', // Subjudul grafik
                style: {
                    fontSize: '14px' // Ukuran teks subjudul
                }
            },
            chart: {
                type: 'column' // Menggunakan grafik tipe kolom/bar
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },
            plotOptions: {
                column: {
                    depth: 25 // Menambahkan kedalaman (depth) pada grafik kolom
                }
            },
            series: [{
                data: [29.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]
            }]
        });

        Highcharts.chart('container', {
            title: {
                text: 'Grafik Penjualan Tahunan', // Judul grafik
                style: {
                    fontSize: '18px' // Ukuran teks judul
                }
            },
            subtitle: {
                text: 'Data Penjualan dalam Satuan Juta', // Subjudul grafik
                style: {
                    fontSize: '14px' // Ukuran teks subjudul
                }
            },
            chart: {
                type: 'area'
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },
            plotOptions: {
                series: {
                    fillOpacity: 0.1
                }
            },
            series: [{
                data: [29.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]
            }]
        });
    </script>
    <script src="{{ asset('assets') }}/js/plugin/chart-circle/circles.min.js"></script>
@endsection
