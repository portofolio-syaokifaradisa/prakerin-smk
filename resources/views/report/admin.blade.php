@extends('layout.report')

@section('content')
<table class="table mt-2 content-table">
    <thead>
        <tr>
            <th>No</th>
            <th>Email</th>
            <th>Pemegang Akun</th>
        </tr>
    </thead>
    <tbody>
        @for ($i = 0; $i < count($data); $i++)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $data[$i]->email }}</td>
                <td>{{ $data[$i]->Information->name }}</td>
            </tr>
        @endfor
    </tbody>
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