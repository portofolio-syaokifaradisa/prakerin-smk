@extends('layout.app')

@section('content')
<div class="card">
  <div class="card-header">
    <h3 class="card-title mt-2">Data Bimbingan</h3>
  </div>
  <div class="card-body">
    <table class="datatables table table-bordered table-striped">
      <thead>
      <tr>
        <th style="width: 7%">No</th>
        <th>Tempat Magang</th>
        <th>Pemilik</th>
        <th>Siswa</th>
        <th>Aksi</th>
      </tr>
      </thead>
      <tbody>
        @foreach ($application_letters as $index => $data)
          <tr>
            <td class="align-middle text-center">{{ $index+1 }}</td>
            <td class="align-middle">
              {{ $data['agency_name'] }} <br>
              {{ $data['agency_address'] }} <br>
              {{ $data['agency_region'] }}
            </td>
            <td class="align-middle">
              {{ $data['agency_owner'] }} <br>
              {{ $data['agency_owner_nip'] }} <br>
              {{ $data['agency_owner_phone'] }}
            </td>
            <td class="align-middle">
              <ul>
                @foreach ($data['students'] as $student)
                  <li>
                    {{ $student }}
                  </li>
                @endforeach
              </ul>
            </td>
            <td class="text-center align-middle">
              <a href="{{ route('app-letter.monitoring.index', ['id' => $data['id']]) }}" class="badge bg-secondary px-3 py-2">
                <i class="fas fa-book mr-1"></i>
                Monitoring Siswa
              </a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<div class="card">
    <div class="card-header">
      <h3 class="card-title mt-2">Data Pembimbing Siswa Magang</h3>
      <a href="{{ route('mentoring-print') }}" class="btn btn-outline-info float-right"><i class="fas fa-print mr-2"></i>Cetak Siswa Bimbingan</a>
    </div>
    <div class="card-body">
      @if (Session::has('eval-success'))
        <div class="alert alert-success">{{ Session::get('eval-success') }}</div>
      @elseif(Session::has('eval-error'))
        <div class="alert alert-danger">{{ Session::get('eval-error') }}</div>
      @endif
      <table class="datatables table table-bordered table-striped">
        <thead>
        <tr>
          <th style="width: 7%">No</th>
          <th>Siswa</th>
          <th>Wilayah</th>
          <th>Nilai</th>
          <th>Nilai Akhir</th>
          <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
          @for ($i = 0; $i < count($mentor); $i++)
            @if ($mentor[$i]->student)
              <tr>
                <td class="align-middle">{{ $i + 1 }}</td>
                <td class="align-middle">
                  {{ $mentor[$i]->Student->name }} <br>
                  {{ $mentor[$i]->Student->nisn }} <br>
                  {{ $mentor[$i]->Student->grade_class->grade . ' ' .  $mentor[$i]->Student->grade_class->Department->name }}
                </td>
                <td class="align-middle">
                  {{ $mentor[$i]->Mentor->Region->name }} <br>
                  {{ $mentor[$i]->Mentor->Region->city }}
                </td>
                <td>
                  <small>
                    Pengetahuan Teori ({{ $mentor[$i]->Student->Evaluation->teori ?? '0' }})<br>
                    Keterampilan Dasar ({{ $mentor[$i]->Student->Evaluation->keterampilan ?? '0' }})<br>
                    Keselamatan Kerja ({{ $mentor[$i]->Student->Evaluation->keselamatan ?? '0' }})<br>
                    Disiplin Kerja ({{ $mentor[$i]->Student->Evaluation->disiplin ?? '0' }})<br>
                    Sikap dan Tanggung Jawab ({{ $mentor[$i]->Student->Evaluation->sikap ?? '0' }})<br>
                  </small>
                </td>
                <td class="align-middle text-center">
                  {{ ($mentor[$i]->Student->Evaluation->mean_score ?? 0) . " (" . ($mentor[$i]->Student->Evaluation->final_score ?? 'E') . ")" }}
                </td>
                <td class="text-center align-middle">
                  @if ($mentor[$i]->Student->Evaluation)
                    <a href="{{ route('evaluation.edit', ['studentId' => $mentor[$i]->Student->id]) }}">
                      Edit Penilaian
                    </a>
                  @else
                    <a href="{{ route('evaluation.create', ['studentId' => $mentor[$i]->Student->id]) }}">
                      Beri Penilaian
                    </a>
                  @endif
                </td>
              </tr>
            @endif
          @endfor
        </tbody>
      </table>
    </div>
</div>
@endsection