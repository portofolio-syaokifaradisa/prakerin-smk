@extends('layout.report')

@section('content')
<table class="table mt-2 content-table">
    <thead>
        <tr>
        <th style="width: 5%">No</th>
        <th style="width: 15%">Tanggal</th>
        <th style="width: 20%">Industri</th>
        <th style="width: 20%">Nama Siswa</th>
        <th style="width: auto">Aktivitas</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $index => $journal)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ date('d-m-Y', strtotime($journal->date)) }}</td>
                <td>
                    {{ $journal->application_letter->agency->name }} <br>
                    {{ $journal->application_letter->agency->region->name }} <br>
                    {{ $journal->application_letter->agency->region->city }}
                </td>
                <td>
                    {{ $journal->student->name ?? $journal->student}} <br>
                    {{ $journal->student->grade_class->Department->name ?? $journal->department }}
                </td>
                <td>{{ $journal->activity }}</td>
            </tr>
        @endforeach
    </tbody>
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