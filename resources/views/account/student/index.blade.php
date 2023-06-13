@extends('layout.app')

@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title mt-2">Data Akun Siswa</h3>
      <a href="{{ route('student-create') }}" class="btn btn-primary float-right px-3"><i class="fas fa-plus mr-2"></i>Tambah Murid</a>
      <a href="{{ route('student-print') }}" class="btn btn-outline-info float-right mr-2"><i class="fas fa-print mr-2"></i>Cetak Akun Siswa</a>
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
          <th>Nama Siswa</th>
          <th>NISN</th>
          <th>Kelas</th>
          <th>Email</th>
          <th>Nilai</th>
          <th style="width: 10%">Aksi</th>
        </tr>
        </thead>
        <tbody>
            
          @for ($i = 0; $i < count($student); $i++)
            <tr>
              <td class="align-middle">{{ $i + 1 }}</td>
              <td class="align-middle">{{ $student[$i]->name }}</td>
              <td class="align-middle">{{ $student[$i]->nisn }}</td>
              <td class="align-middle">{{ $student[$i]->grade . " - " . $student[$i]->department }}</td>
              <td class="align-middle">{{ $student[$i]->email }}</td>
              <td class="align-middle">
                <small>
                  Pengetahuan Teori ({{ $student[$i]->Evaluation->teori ?? '0' }})<br>
                  Keterampilan Dasar ({{ $student[$i]->Evaluation->keterampilan ?? '0' }})<br>
                  Keselamatan Kerja ({{ $student[$i]->Evaluation->keselamatan ?? '0' }})<br>
                  Disiplin Kerja ({{ $student[$i]->Evaluation->disiplin ?? '0' }})<br>
                  Sikap dan Tanggung Jawab ({{ $student[$i]->Evaluation->sikap ?? '0' }})<br>
                </small>
              </td>
              <td class="text-center align-middle">
                <a href="{{ route('student.edit', ['id' => $student[$i]->id]) }}" class="badge bg-secondary">Ubah</a>
                <a href="#" class="badge bg-danger" onclick="deleteItem('{{ route('student-delete', ['id' => $student[$i]->id]) }}')">Hapus</a>
              </td>
            </tr>
          @endfor
        </tbody>
      </table>
    </div>
  </div>

  <script src="{{ asset('js/account/student.js') }}"></script>
@endsection