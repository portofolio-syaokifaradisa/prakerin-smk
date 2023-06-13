@extends('layout.report')

@section('content')
<table class="table mt-2 content-table">
    <tr>
        <th>No</th>
        <th>Wilayah</th>
        <th>Kota</th>
    </tr>
    @for ($i = 0; $i < count($data); $i++)
        <tr>
            <td class="text-center">{{ $i+1 }}</td>
            <td>{{ $data[$i]->name }}</td>
            <td>{{ $data[$i]->city }}</td>
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