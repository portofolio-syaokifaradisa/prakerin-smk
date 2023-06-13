@extends('layout.app')

@section('content')
    <div class="card">
    <div class="card-header">
        <h3 class="card-title mt-2">Judul Laporan</h3>
        <a href="{{ route('student-report-title.report') }}" class="btn btn-outline-info float-right">
            <i class="fas fa-print mr-2"></i>
            Cetak Judul Laporan
        </a>
    </div>
    <div class="card-body">
        <table class="datatables table table-bordered table-striped">
        <thead>
            <tr>
            <th style="width: 5%">No</th>
            <th style="width: auto">Judul</th>
            <th style="width: auto">Siswa</th>
            <th style="width: 10%">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reports as $index => $report)
            <tr>
                <td class="text-center align-middle">
                    {{ $index + 1 }}
                </td>
                <td class="align-middle">
                    {{ $report->title }}
                </td>
                <td class="align-middle">
                    {{ $report->student->name }} <br>
                    {{ $report->student->grade_class->Department->name }}
                </td>
                <td class="text-center align-middle">
                    @if ($report->status == "ACCEPTED")
                        Disetujui
                    @elseif($report->status == "REJECTED")
                        Ditolak
                    @else 
                        Menunggu
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
        </table>
    </div>
    </div>
@endsection