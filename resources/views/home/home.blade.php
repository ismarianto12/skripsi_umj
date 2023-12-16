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
    <div class="page-inner mt--5" style="margin: 20px;">


        <div class="container">
            <h4>
                SELAMAT DATANG DI
                DI KELAS VIII SMP
                MUHAMMADIYAH
                17 CIPUTAT
            </h4>
            <div class="col-md-12 row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.7308909059384!2d106.76057277400888!3d-6.299049693690081!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f029a2ec252b%3A0x9558b1cf7c31429a!2sMuhammadiyah%20Junior%20High%20School%2017%20Ciputat!5e0!3m2!1sen!2sid!4v1700749597242!5m2!1sen!2sid"
                                width="300" height="350" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>

                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <img src="https://sekolah.link/wp-content/uploads/2022/06/AF1QipPdjVA5aHjz9qCMfXZRlqtLM7G12qlseOIcNN0vw800-h500-k-no.jpeg"
                                class="img-responsive" style="width:100%" />
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/series-label.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/modules/export-data.js"></script>
        <script src="https://code.highcharts.com/modules/accessibility.js"></script>

        <script src="{{ asset('assets') }}/js/plugin/chart-circle/circles.min.js"></script>
    @endsection
