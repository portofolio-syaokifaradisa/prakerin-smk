@extends('layout.report')

@section('content')
<table class="table mt-2 content-table">
    <tr>
        <th class="text-center" rowspan="2" style="width: 7%">No</th>
        <th class="text-center" rowspan="2">Industri</th>
        <th class="text-center" rowspan="2">Nama Siswa</th>
        <th class="text-center" colspan="4">Jumlah Absensi</th>
    </tr>
    <tr>
        <th class="text-center">Hadir</th>
        <th class="text-center">Izin</th>
        <th class="text-center">Sakit</th>
        <th class="text-center">Alpha</th>
    </tr>
    @for ($i = 0; $i < count($data); $i++)
          <tr>
            <td class="text-center align-middle">{{ $i + 1 }}</td>
            <td class="text-center align-middle">
                {{ $data[$i]->department }}
            </td>
            <td class="align-middle">
              {{ $data[$i]->student }} <br>
            </td>
            <td class="text-center align-middle">
              {{ $data[$i]->present }}
            </td>
            <td class="text-center align-middle">
                {{ $data[$i]->permit }}
            </td>
            <td class="text-center align-middle">
                {{ $data[$i]->sick }}
            </td>
            <td class="text-center align-middle">
                {{ $data[$i]->alpha }}
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