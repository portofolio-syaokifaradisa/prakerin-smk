@extends('layout.report')

@section('content')
<table class="table mt-2 content-table">
    <tr>
        <th>No</th>
        <th>Judul</th>
        <th>Siswa</th>
        <th>NISN</th>
        <th>Jurusan</th>
    </tr>
    @for ($i = 0; $i < count($data); $i++)
        <tr>
            <td class="text-center">{{ $i+1 }}</td>
            <td>{{ $data[$i]->title }}</td>
            <td>
                {{ $data[$i]->student->name ?? $data[$i]->student }}
            </td>
            <td>
                {{ $data[$i]->student->nisn ?? $data[$i]->nisn }}
            </td>
            <td>
                {{ $data[$i]->student->grade_class->Department->name ?? $data[$i]->department }} 
            </td>
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