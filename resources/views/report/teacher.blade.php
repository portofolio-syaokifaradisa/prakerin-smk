@extends('layout.report')

@section('content')
<table class="table mt-2 content-table">
    <tr>
        <th style="width: 7%">No</th>
        <th>Identitas</th>
        <th>Jabatan</th>
        @if (!isset($type))
            <th>Email</th>
        @endif
    </tr>
    @for ($i = 0; $i < count($data); $i++)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>
                {{ $data[$i]->name }} <br>
                {{ $data[$i]->nip }}
            </td>
            <td>{{ $data[$i]->position }}</td>
            @if (!isset($type))
                <td>{{ $data[$i]->email }}</td>
            @endif
        </tr>
    @endfor
</table>

<table class="mt-5 ttd" >
    <tr>
        <td style="width: 70%">

        </td>
        <td style="width: auto">
            Haruyan, {{ FormatHelper::toIndonesianDateFormat(date('d-m-Y', strtotime(now()))) }}<br>
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