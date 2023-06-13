@extends('layout.report')

@section('content')
<table class="table mt-2 content-table">
    <tr>
        <th>No</th>
        <th>Siswa</th>
        <th>NISN</th>
        <th>Jurusan</th>
        <th>Penilaian</th>
    </tr>
    @for ($i = 0; $i < count($data); $i++)
        <tr>
            <td class="text-center align-middle" style="width: ">
                {{ $i+1 }}
            </td>
            <td class="align-middle">
                {{ $data[$i]['student'] }}
            </td>
            <td class="align-middle">
                {{ $data[$i]['nisn'] }}
            </td>
            <td class="align-middle">
                {{ $data[$i]['department'] }}
            </td>
            <td>
                Pengetahuan Teori       : {{ $data[$i]['teori'] }} <br>
                Keterampilan Dasar      : {{ $data[$i]['keterampilan'] }} <br>
                Keselamatan Kerja       : {{ $data[$i]['keselamatan'] }} <br>
                Disiplin Kerja          : {{ $data[$i]['disiplin'] }} <br>
                Sikap dan Tanggungjawab : {{ $data[$i]['sikap'] }} <br>
                Nilai Akhir             : {{ $data[$i]['score'] }} - {{ $data[$i]['predicate'] }}
            </td>
        </tr>
    @endfor
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