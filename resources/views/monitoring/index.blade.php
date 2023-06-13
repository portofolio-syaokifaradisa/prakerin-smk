@extends('layout.app')

@section('content')
<div class="card">
  <div class="card-header">
    <h3 class="card-title mt-2">Data Bimbingan</h3>
    <a href="{{ route('app-letter.monitoring.create', ['id' => $app_letter_id]) }}" class="btn btn-primary float-right px-3"><i class="fas fa-plus mr-2"></i>Tambah Data Bimbingan</a>
    <a href="{{ route('app-letter.monitoring.print', ['id' => $app_letter_id]) }}" class="btn btn-outline-info float-right mr-2"><i class="fas fa-print mr-2"></i>Cetak Monitoring</a>
  </div>
  <div class="card-body">
    @if (Session::has('success'))
      <div class="alert alert-success">{{ Session::get('success') }}</div>
    @elseif(Session::has('error'))
      <div class="alert alert-danger">{{ Session::get('error') }}</div>
    @endif
    <table class="datatables table table-bordered table-striped">
      <thead>
      <tr>
        <th style="width: 7%">No</th>
        <th>Tanggal</th>
        <th>Isi Monitoring</th>
        <th>Aksi</th>
      </tr>
      </thead>
      <tbody>
        @foreach ($monitorings as $index => $data)
          <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ date('d-m-Y', strtotime($data->date)) }}</td>
            <td>{{ $data->description }}</td>
            <td class="align-middle">
              <a href="{{ route('app-letter.monitoring.edit', ['id' => $app_letter_id, 'monitoring_id' => $data->id]) }}" class="badge bg-secondary">Ubah</a>
              <a href="#" class="badge bg-danger" onclick="deleteItem('{{ route('app-letter.monitoring.delete', ['id' => $app_letter_id, 'monitoring_id' => $data->id]) }}')">Hapus</a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<div class="card">
  <div class="card-header">
    <h3 class="card-title mt-2">Data Absensi Siswa Magang</h3>
    <a href="{{ route('app-letter.attedance.print-by-app-letter', ['id' => $app_letter_id]) }}" class="btn btn-outline-info float-right"><i class="fas fa-print mr-2"></i>Cetak Absensi Siswa</a>
  </div>
  <div class="card-body">
    <table class="datatables table table-bordered table-striped">
      <thead>
      <tr>
        <th class="text-center" style="width: 7%">No</th>
        <th class="text-center">Nama Siswa</th>
        <th class="text-center">Tanggal</th>
        <th class="text-center">Jam</th>
        <th class="text-center">Status</th>
        <th class="text-center">Keterangan</th>
      </tr>
      </thead>
      <tbody>
        <?php $i = 0; ?>
        @foreach ($attendances as $attendance)
          <tr>
            <td class="text-center align-middle">{{ $i + 1 }}</td>
            <td class="align-middle">
              {{ $attendance->Student->name }}
            </td>
            <td class="text-center align-middle">
              {{ date('d-m-Y', strtotime($attendance->date)) }}
            </td>
            <td class="text-center align-middle">
              @if ($attendance->in)
                {{ date('H:m', strtotime($attendance->in)) . " - ". date('H:m', strtotime($attendance->out)) }}
              @else
                -
              @endif
            </td>
            <td class="text-center align-middle">
              @if ($attendance->in)
                Hadir
              @elseif ($attendance->isAlpha)
                Alpha
              @elseif ($attendance->isPermit)
                Izin
              @elseif ($attendance->isSick)
                Sakit
              @endif
            </td>
            <td class="align-middle">
              {{ $attendance->description ?? '-' }}
            </td>
          </tr>
          <?php $i++; ?>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<div class="card">
    <div class="card-header">
      <h3 class="card-title mt-2">Jurnal Kegiatan Siswa</h3>
      <a href="{{ route('app-letter.journal.print', ['id' => $app_letter_id]) }}" class="btn btn-outline-info float-right"><i class="fas fa-print mr-2"></i>Cetak Jurnal Kegiatan</a>
    </div>
    <div class="card-body">
      <table class="datatables table table-bordered table-striped">
        <thead>
            <tr>
            <th style="width: 5%">No</th>
            <th style="width: 10%">Tanggal</th>
            <th style="width: 25%">Nama Siswa</th>
            <th style="width: auto">Aktivitas</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($journals as $index => $journal)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ date('d-m-Y', strtotime($journal->date)) }}</td>
                    <td>{{ $journal->student->name }}</td>
                    <td>{{ $journal->activity }}</td>
                </tr>
            @endforeach
        </tbody>
      </table>
    </div>
</div>

<div class="card">
  <div class="card-header">
    <h3 class="card-title mt-2">Judul Laporan</h3>
  </div>
  <div class="card-body">
    <table class="datatables table table-bordered table-striped">
      <thead>
          <tr>
          <th style="width: 5%">No</th>
          <th style="width: auto">Judul</th>
          <th style="width: auto">Siswa</th>
          <th style="width: 10%">Status</th>
          <th style="width: 10%">Aksi</th>
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
            <td class="text-center align-middle">
              @if ($report->is_guidance && $report->status == "PENDING")
                <a href="#" onclick="confirmationAlert('Konfirmasi Penerimaan Judul', 'Yakin Ingin Menerima Judul Laporan', '{{ route('student-report-title.accept', ['id' => $report->id, 'application_letter_id' => $app_letter_id ]) }}')" class="badge bg-success">Terima</a>
                <a href="#" onclick="confirmationAlert('Konfirmasi Penolakan Judul', 'Yakin Ingin Menolak Judul Laporan', '{{ route('student-report-title.refuse', ['id' => $report->id, 'application_letter_id' => $app_letter_id]) }}')" class="badge bg-danger">Tolak</a>
              @else
                -
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection