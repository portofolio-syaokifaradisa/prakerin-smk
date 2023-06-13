@extends('layout.report')

@section('content')
<table class="table mt-2 content-table">
    <tr>
        <th rowspan="2">No</th>
        <th rowspan="2">Tanggal</th>
        <th colspan="2">Masuk</th>
        <th colspan="2">Keluar</th>
        <th colspan="3">Keterangan</th>
    </tr>
    <tr>
        <th>Jam</th>
        <th>Paraf</th>
        <th>Jam</th>
        <th>Paraf</th>
        <th>Alpha</th>
        <th>Izin</th>
        <th>Sakit</th>
    </tr>
    @for ($i = 0; $i < count($data); $i++)
        <tr>
            <td class="text-center" style="width: ">
                {{ $i+1 }}
            </td>
            <td class="text-center">{{ date('d-m-Y', strtotime($data[$i]->date)) }}</td>
            <td class="text-center">
                @if ($data[$i]->in)
                    {{ date("H:m", strtotime($data[$i]->in)) }}
                @else
                    -
                @endif
            </td>
            <td>

            </td>
            <td class="text-center">
                @if ($data[$i]->out)
                    {{ date("H:m", strtotime($data[$i]->out)) }}
                @else
                    -
                @endif
            </td>
            <td>

            </td>
            <td class="text-center">
                {{ $data[$i]->isAlpha ? "Ya" : '-' }}
            </td>
            <td class="text-center">
                {{ $data[$i]->isPermit ? "Ya" : '-' }}
            </td>
            <td class="text-center">
                {{ $data[$i]->isSick ? "Ya" : '-' }}
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
            Siswa Magang
            <br>
            <br>
            <br>
            <br>
            {{ Auth::user()->information->name }} <br>
            NISN.{{ Auth::user()->information->nisn }}
        </td>
    </tr>
</table>
@endsection