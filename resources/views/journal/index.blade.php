@extends('layout.app')

@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title mt-2">Data Jurnal kegiatan</h3>
      <a href="{{ route('app-letter.journal.create', ['id' => $app_letter_id]) }}" class="btn btn-primary float-right px-3">
        <i class="fas fa-plus mr-2"></i>
        Laporkan kegiatan
      </a>
      <a href="{{ route('app-letter.journal.print', ['id' => $app_letter_id]) }}" class="btn btn-outline-info float-right mr-2">
        <i class="fas fa-print mr-2"></i>
        Cetak Jurnal Kegiatan
      </a>
    </div>
    <div class="card-body">
      @if (Session::has('journal-success'))
        <div class="alert alert-success">{{ Session::get('journal-success') }}</div>
      @elseif(Session::has('journal-error'))
        <div class="alert alert-danger">{{ Session::get('journal-error') }}</div>
      @endif
      <table class="datatables table table-bordered table-striped">
        <thead>
        <tr>
          <th class="text-center" style="width: 50px">No</th>
          <th class="text-center" style="width: 140px">Tanggal</th>
          <th class="text-center">Kegiatan</th>
          <th class="text-center" style="width: 10%">Aksi</th>
        </tr>
        </thead>
        <tbody>
          @foreach ($journals as $index => $data)
            <tr>
                <td class="align-middle text-center">
                    {{ $index + 1 }}
                </td>
                <td class="align-middle text-center">
                    {{ date('d-m-Y', strtotime($data->date)) }}
                </td>
                <td class="align-middle">
                    {{ $data->activity }}
                </td>
                <td class="align-middle">
                  <a href="{{ route('app-letter.journal.edit', ['id' => $app_letter_id, 'journal_id' => $data->id]) }}" class="badge bg-secondary">Ubah</a>
                  <a href="#" class="badge bg-danger" onclick="deleteItem('{{ route('app-letter.journal.delete', ['id' => $app_letter_id, 'journal_id' => $data->id]) }}')">Hapus</a>
                </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
</div>

<div class="card">
  <div class="card-header">
    <h3 class="card-title mt-2">Data Absensi</h3>
    @if($attendance)
      @if ($attendance->in and !$attendance->out)
        <a href="{{ route('app-letter.attedance.out', ['id' => $app_letter_id]) }}" class="btn btn-primary float-right px-3 mr-2">
          <i class="fas fa-plus mr-2"></i>
          Absen Sore
        </a>
      @endif
    @else
      <a href="{{ route('app-letter.attedance.create', ['id' => $app_letter_id, 'type' => 'alpha']) }}" class="btn btn-primary float-right px-3">
        <i class="fas fa-plus mr-2"></i>
        Alpha
      </a>
      <a href="{{ route('app-letter.attedance.create', ['id' => $app_letter_id, 'type' => 'izin']) }}" class="btn btn-primary float-right px-3 mr-2">
        <i class="fas fa-plus mr-2"></i>
        Izin
      </a>
      <a href="{{ route('app-letter.attedance.sick', ['id' => $app_letter_id]) }}" class="btn btn-primary float-right px-3 mr-2">
        <i class="fas fa-plus mr-2"></i>
        sakit
      </a>
      <a href="{{ route('app-letter.attedance.in', ['id' => $app_letter_id]) }}" class="btn btn-primary float-right px-3 mr-2">
        <i class="fas fa-plus mr-2"></i>
        Absen Pagi
      </a>
    @endif
    <a href="{{ route('app-letter.attedance.print', ['id' => $app_letter_id]) }}" class="btn btn-outline-info float-right mr-2">
      <i class="fas fa-print mr-2"></i>
      Cetak Absensi
    </a>
  </div>
  <div class="card-body">
    @if (Session::has('attendance-success'))
      <div class="alert alert-success">{{ Session::get('attendance-success') }}</div>
    @elseif(Session::has('attendance-error'))
      <div class="alert alert-danger">{{ Session::get('attendance-error') }}</div>
    @endif
    <table class="datatables table table-bordered table-striped">
      <thead>
      <tr>
        <th class="text-center" style="width: 50px">No</th>
        <th class="text-center" style="width: 140px">Tanggal</th>
        <th class="text-center">Status</th>
        <th class="text-center">Jam <br>(Masuk - Keluar)</th>
        <th class="text-center">Keterangan</th>
      </tr>
      </thead>
      <tbody>
        @foreach ($attedances as $index => $data)
          <tr>
              <td class="text-center">{{ $index + 1 }}</td>
              <td class="text-center">{{ date('d-m-Y', strtotime($data->date)) }}</td>
              <td class="text-center">
                @if ($data->in)
                  Hadir
                @elseif ($data->isPermit)
                  Izin
                @elseif ($data->isAlpha)
                  Alpha
                @else
                  Sakit
                @endif
              </td>
              <td class="text-center">
                @if ($data->in)
                  {{ date('H:m', strtotime($data->in)) }} 
                  @if ($data->out)
                    - {{ date('H:m', strtotime($data->out)) }} 
                  @endif
                @else
                  -
                @endif
              </td>
              <td>
                {{ $data->description ?? '-' }}
              </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<div class="card">
  <div class="card-header">
    <h3 class="card-title mt-2">Data Monitoring</h3>
  </div>
  <div class="card-body">
    <table class="datatables table table-bordered table-striped">
      <thead>
      <tr>
        <th class="text-center" style="width: 50px">No</th>
        <th class="text-center" style="width: 140px">Tanggal</th>
        <th class="text-center">Pembimbing</th>
        <th class="text-center">Isi Bimbingan</th>
      </tr>
      </thead>
      <tbody>
        @foreach ($monitorings as $index => $data)
          <tr>
              <td class="align-middle text-center">
                  {{ $index + 1 }}
              </td>
              <td class="align-middle text-center">
                  {{ date('d-m-Y', strtotime($data->date)) }}
              </td>
              <td class="align-middle">
                  {{ $data->teacher->name }}
              </td>
              <td class="align-middle">
                  {{ $data->description }}
              </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<div class="card">
  <div class="card-header">
    <h3 class="card-title mt-2">Nilai Magang {{ Auth::user()->information->name }}</h3>
  </div>
  <div class="card-body">
    <table class="table table-bordered table-striped">
      <thead>
      <tr>
        <th class="text-center align-middle">Pengetahuan Teori</th>
        <th class="text-center align-middle">Keteramplan Dasar</th>
        <th class="text-center align-middle">Keselamatan Kerja</th>
        <th class="text-center align-middle">Disiplin Kerja</th>
        <th class="text-center align-middle">Sikap dan Tanggung Jawab</th>
        <th class="text-center align-middle">Nilai Akhir</th>
      </tr>
      </thead>
      <tbody>
          <tr>
              <td class="text-center align-middle">{{ Auth::user()->information->Evaluation->teori ?? '0' }}</td>
              <td class="text-center align-middle">{{ Auth::user()->information->Evaluation->keterampilan ?? '0' }}</td>
              <td class="text-center align-middle">{{ Auth::user()->information->Evaluation->keselamatan ?? '0' }}</td>
              <td class="text-center align-middle">{{ Auth::user()->information->Evaluation->disiplin ?? '0' }}</td>
              <td class="text-center align-middle">{{ Auth::user()->information->Evaluation->sikap ?? '0' }}</td>
              <td class="text-center align-middle">
                {{ Auth::user()->information->Evaluation->mean_score ?? '0' }} ({{ Auth::user()->information->Evaluation->final_score ?? 'E' }})
              </td>
          </tr>
      </tbody>
    </table>
  </div>
</div>

<div class="card">
  <div class="card-header">
    <h3 class="card-title mt-2">Judul Laporan Magang</h3>
  </div>
  <div class="card-body">
    <form action="@if (isset(Auth::user()->information->student_report[0]->status))
        {{ route('student-report-title.update', ['id' => Auth::user()->information->student_report[0]->id]) }}
      @else
        {{ route('student-report-title.store') }}
    @endif" method="POST">
      @csrf
      @if (isset(Auth::user()->information->student_report[0]->status))
        @method('PUT')
      @endif

      <div class="form-group">
        <label>
          Judul Laporan @if (isset(Auth::user()->information->student_report[0]->status))
            (@if (Auth::user()->information->student_report[0]->status == "ACCEPTED")
              Disetujui
            @elseif(Auth::user()->information->student_report[0]->status == "REJECTED")
              Ditolak
            @else 
              Menunggu
            @endif)
          @endif
        </label>
        <div class="row mx-1">
          <input type="hidden" value="{{ $app_letter_id }}" name="letter_id" readonly>
          <input type="text" class="form-control @if(isset(Auth::user()->information->student_report[0]))
            @if (Auth::user()->information->student_report[0]->status != "ACCEPTED")
              col-11
            @endif
          @else
            col-11
          @endif" value="{{ Auth::user()->information->student_report[0]->title ?? '' }}" placeholder="Judul Laporan" name="title"
          @if (isset(Auth::user()->information->student_report[0]))
            @if (Auth::user()->information->student_report[0]->status == "ACCEPTED")
              readonly
            @endif
          @endif>
          @if (isset(Auth::user()->information->student_report[0]))
            @if (Auth::user()->information->student_report[0]->status != "ACCEPTED")
              <button class="btn btn-primary col-1">
                Ubah
              </button>
            @endif
          @else
            <button class="btn btn-primary col-1">
              Simpan
            </button>
          @endif
        </div>
      </div>
    </form>
    <table class="table table-bordered table-striped">
      <thead>
      <tr>
        <th class="text-center align-middle">No</th>
        <th class="text-center align-middle">Judul</th>
        <th class="text-center align-middle">Oleh</th>
        <th class="text-center align-middle">Status</th>
      </tr>
      </thead>
      <tbody>
        @if (count($reports) > 0)
          @foreach ($reports as $index => $report)
            <tr>
              <td class="text-center align-middle">{{ $index + 1 }}</td>
              <td class="align-middle">
                {{ $report->title }}
              </td>
              <td class="align-middle">
                {{ $report->student->name }} <br>
                {{ $report->student->grade_class->Department->name }}
              </td>
              <td class="align-middle text-center">
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
        @else
            <tr>
              <td colspan="4" class="text-center">
                Belum Ada Data Judul Laporan
              </td>
            </tr>
        @endif
          
      </tbody>
    </table>
  </div>
</div>
@endsection