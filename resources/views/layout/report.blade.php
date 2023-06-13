<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ $title }}</title>
        <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('vendor/adminlte/adminlte.min.css') }}">
        <style>
            .ttd, .content-table, .header-table{
                width: 100%;
            }
            .ttd tr td{
                font-size: 10pt !important;
            }
            .content-table tr th{
                text-align: center;
            }
            .content-table tr th, .content-table tr td{
                font-size: 10pt !important;
                vertical-align: middle;
            }
            .content-table tr td:first-child { 
                text-align: center;
                width: 10px 
            }
        </style>
    </head>
    <body class="text-center">
        <table class="header-table">
            <thead>
                <tr>
                    <th style="width: 10%">
                        <img src="{{ asset('img/kalsel_logo.jpg') }}" alt="" class="float-left" style="width: 80px; height: 100px;">
                    </th>
                    <th class="text-center" style="width: auto">
                        <p class="h6">PEMERINTAH KABUPATEN HULU SUNGAI TENGAH</p>
                        <p class="h6">DINAS PENDIDIKAN DAN KEBUDAYAAN</p>
                        <p class="h6">SMK AL-HIDAYAH BARABAI</p>
                        <p class="h6 text-center"><small>Jl. Divisi IV ALRI Andang Kec. Haruyan Kab. Hulu Sungai tengah 71363</small></p>
                        <p class="h6 text-center"><small>Email : smkahbrb@yahoo.com</small></p>
                    </th>
                    <th style="width: 10%">
                        <img src="{{ asset('img/logo.jpg') }}" alt="" class="float-right" style="width: 100px; height: 100px;">
                    </th>
                </tr>
            </thead>
        </table>
        <hr>
        <h6 class="text-center mt-5 mb-3">{{ $title }}</h6>
        @yield('content')
        <script src="{{ asset('vendor/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
    </body>
</html>