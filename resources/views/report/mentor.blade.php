@extends('layout.report')

@section('content')
<table class="table mt-2 content-table">
    <tr>
        <th>No</th>
        <th>Guru</th>
        <th>Email</th>
        <th>Wilayah</th>
    </tr>
    @for ($i = 0; $i < count($data); $i++)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>
                {{ $data[$i]->Teacher->nip ?? $data[$i]->nip }} <br>
                {{ $data[$i]->Teacher->name ?? $data[$i]->name }} <br>
                {{ $data[$i]->Teacher->grade_class->Department->name ?? $data[$i]->department }} 
            </td>
            <td>
                {{ $data[$i]->Teacher->user->email ?? $data[$i]->email }}
            </td>
            <td>
                {{ $data[$i]->region->name ?? $data[$i]->region }} <br>
                {{ $data[$i]->region->city ?? $data[$i]->city }}
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