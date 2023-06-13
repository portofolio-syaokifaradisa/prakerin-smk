@extends('layout.app')

@section('content')
<div class="card">
  <div class="card-header">
    <h3 class="card-title mt-2">Data Bimbingan</h3>
    <a href="{{ route('monitoring.print-all') }}" class="btn btn-outline-info float-right">
      <i class="fas fa-print mr-2"></i>
      Cetak Monitoring
    </a>
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
          <th>Industri</th>
          <th>Pembimbing</th>
          <th>Tanggal</th>
          <th>Isi Monitoring</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($monitorings as $index => $data)
          <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $data->application_letter->agency->name }}</td>
            <td>{{ $data->teacher->name }}</td>
            <td>{{ date('d-m-Y', strtotime($data->date)) }}</td>
            <td>{{ $data->description }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<div class="card">
  <div class="card-header">
    <h3 class="card-title mt-2">Data Absensi Siswa</h3>
    <a href="{{ route('attendance.print-all') }}" class="btn btn-outline-info float-right">
      <i class="fas fa-print mr-2"></i>
      Cetak Absensi
    </a>
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
        <th class="text-center" style="width: 7%">No</th>
        <th class="text-center">Industri</th>
        <th class="text-center">Nama Siswa</th>
        <th class="text-center">Tanggal</th>
        <th class="text-center">Jam</th>
        <th class="text-center">Status</th>
        <th class="text-center">Keterangan</th>
      </tr>
      </thead>
      <tbody>
        @for ($i = 0; $i < count($attendances); $i++)
          <tr>
            <td class="text-center align-middle">{{ $i + 1 }}</td>
            <td>{{ $attendances[$i]['agency'] }}</td>
            <td class="align-middle">
              {{ $attendances[$i]['student'] }}
            </td>
            <td class="text-center align-middle">
              {{ date('d-m-Y', strtotime($attendances[$i]->date)) }}
            </td>
            <td class="text-center align-middle">
              @if ($attendances[$i]->in)
                {{ date('H:m', strtotime($attendances[$i]->in)) . " - ". date('H:m', strtotime($attendances[$i]->out)) }}
              @else
                -
              @endif
            </td>
            <td class="text-center align-middle">
              @if ($attendances[$i]->in)
                Hadir
              @elseif ($attendances[$i]->isAlpha)
                Alpha
              @elseif ($attendances[$i]->isPermit)
                Izin
              @elseif ($attendances[$i]->isSick)
                Sakit
              @endif
            </td>
            <td class="align-middle">
              {{ $attendances[$i]->description ?? '-' }}
            </td>
          </tr>
        @endfor
      </tbody>
    </table>
  </div>
</div>

<div class="card">
  <div class="card-header">
    <h3 class="card-title mt-2">Jurnal Kegiatan Siswa</h3>
    <a href="{{ route('journal.print-all') }}" class="btn btn-outline-info float-right">
      <i class="fas fa-print mr-2"></i>
      Cetak Jurnal
    </a>
  </div>
  <div class="card-body">
    <table class="datatables table table-bordered table-striped">
      <thead>
          <tr>
          <th style="width: 5%">No</th>
          <th style="width: 10%">Tanggal</th>
          <th style="width: 20%">Industri</th>
          <th style="width: 20%">Nama Siswa</th>
          <th style="width: auto">Aktivitas</th>
          </tr>
      </thead>
      <tbody>
          @foreach ($journals as $index => $journal)
              <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>{{ date('d-m-Y', strtotime($journal->date)) }}</td>
                  <td>{{ $journal->application_letter->agency->name }}</td>
                  <td>{{ $journal->student->name }}</td>
                  <td>{{ $journal->activity }}</td>
              </tr>
          @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection