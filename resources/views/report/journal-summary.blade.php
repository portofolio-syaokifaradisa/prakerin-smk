@extends('layout.report')

@section('content')
<table class="table mt-2 content-table">
    <thead>
        <tr>
        <th style="width: 5%">No</th>
        <th style="width: 15%">NISN</th>
        <th style="width: 20%">Siswa</th>
        <th style="width: 20%">Jurusan</th>
        <th style="width: auto">Pencapaian</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($datas as $index => $data)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $data['nisn'] }}</td>
                <td>
                    {{ $data['student'] }}
                </td>
                <td>
                    {{ $data['department'] }}
                </td>
                <td>{{ $data['competence'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<table class="mt-5 ttd">
    <tr>
        <td style="width: 70%">

        </td>
        <td style="width: auto">
            Haruyan, {{ FormatHelper::toIndonesianDateFormat(date('d-m-Y', strtotime(now()))) }} <br>
            Kepala SMK AL Hidayah Barabai
            <br>
            <br>
            <br>
            <br>
            Akhmad Rahman, S.Pd <br>
            NIP.-
        </td>
    </tr>
</table>
@endsection