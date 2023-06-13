@extends('layout.report')

@section('content')
<table class="table mt-2 content-table">
    <tr>
        <th>No</th>
        <th>Siswa</th>
        <th>Wilayah</th>
        <th>Nilai</th>
        <th>Nilai Akhir</th>
    </tr>
    @for ($i = 0; $i < count($data); $i++)
        <tr>
            <td>{{ $i+1 }}</td>
            <td>
                {{ $data[$i]['student-name'] }} <br>
                {{ $data[$i]['student-nisn'] }} <br>
                {{ $data[$i]['grade-class'] }}
            </td>
            <td>
                {{ $data[$i]['region'] }} <br>
                {{ $data[$i]['city'] }}
            </td>
            <td>
                <small>
                    Pengetahuan Teori ({{ $evaluation->teori ?? '0' }})<br>
                    Keterampilan Dasar ({{ $evaluation->keterampilan ?? '0' }})<br>
                    Keselamatan Kerja ({{ $evaluation->keselamatan ?? '0' }})<br>
                    Disiplin Kerja ({{ $evaluation->disiplin ?? '0' }})<br>
                    Sikap dan Tanggung Jawab ({{ $evaluation->sikap ?? '0' }})<br>
                  </small>
            </td>
            <td>{{ $data[$i]['final_score'] }}</td>
        </tr>
    @endfor
</table>

<table class="mt-5 ttd" >
    <tr>
        <td style="width: 70%"></td>
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