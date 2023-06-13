@extends('layout.report')

@section('content')
<table class="table mt-2 content-table">
    <tr>
        <th>No</th>
        @if (!isset($type))
            <th>Email</th>
        @endif
        <th>Nama</th>
        <th>NISN</th>
        <th>kelas</th>
    </tr>
    @for ($i = 0; $i < count($data); $i++)
        <tr>
            <td>{{ $i+1 }}</td>
            @if (!isset($type))
                <td>{{ $data[$i]->email }}</td>
            @endif
            <td>{{ $data[$i]->name }}</td>
            <td>{{ $data[$i]->nisn }}</td>
            <td>{{ $data[$i]->grade . " " . $data[$i]->department }}</td>
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