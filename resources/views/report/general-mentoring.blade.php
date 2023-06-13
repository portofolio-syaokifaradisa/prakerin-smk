@extends('layout.report')

@section('content')
<table class="table mt-2">
    <thead>
        <tr>
            <th style="width: 7%">No</th>
            <th>Wilayah</th>
            <th>Guru</th>
            <th>Siswa</th>
        </tr>
    </thead>
    <tbody>
        @for ($i = 0; $i < count($data); $i++)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>
                    {{ $data[$i]->Mentor->Region->name }} <br>
                    {{ $data[$i]->Mentor->Region->city }}
                </td>
                <td>
                    {{ $data[$i]->Mentor->Teacher->name }} <br>
                    {{ $data[$i]->Mentor->Teacher->nip }} <br>
                    {{ $data[$i]->Mentor->Teacher->grade_class->Department->name }}
                </td>
                <td>
                    {{ $data[$i]->Student->name }} <br>
                    {{ $data[$i]->Student->nisn }} <br>
                    {{ $data[$i]->Student->grade_class->grade . ' ' . $data[$i]->Student->grade_class->Department->name }}
                </td>
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