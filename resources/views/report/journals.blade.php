@extends('layout.report')

@section('content')
<table class="table mt-2 content-table">
    <tr>
        <th @if(Auth::user()->role == "STUDENT") rowspan="2" @endif>No</th>
        @if (Auth::user()->role != "STUDENT")
            <th>Siswa</th>
        @endif
        <th @if(Auth::user()->role == "STUDENT") rowspan="2" @endif>Tanggal</th>
        <th @if(Auth::user()->role == "STUDENT") rowspan="2" @endif>Kegiatan</th>
        @if (Auth::user()->role == "STUDENT")
            <th colspan="2">Pembimbing</th>
        @endif
    </tr>
    @if (Auth::user()->role == "STUDENT")
        <tr>
            <th>Nama</th>
            <th>Paraf</th>
        </tr>
    @endif

    @for ($i = 0; $i < count($data); $i++)
        <tr>
            <td class="text-center">{{ $i+1 }}</td>
            @if (Auth::user()->role != "STUDENT")
                <td style="width: 150px">
                    {{ $data[$i]->student->name }}
                </td>
            @endif
            <td style="width: 80px">{{ date('d-m-Y', strtotime($data[$i]->date)) }}</td>
            <td>{{ $data[$i]->activity }}</td>
            @if (Auth::user()->role == "STUDENT")
                <td style="width: 150px">
                    {{ $mentor }}
                </td>
                <td style="width: 150px">
                    
                </td>
            @endif
        </tr>
    @endfor
</table>

<table class="mt-5 ttd" >
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