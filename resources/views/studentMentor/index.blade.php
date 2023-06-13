@extends('layout.app')

@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title mt-2">Data Pembimbing Siswa Magang</h3>
      <a href="{{ route('mentoring-create') }}" class="btn btn-primary float-right px-3"><i class="fas fa-plus mr-2"></i>Tentukan Pembimbing Siswa</a>
      <a href="{{ route('mentoring-gen-print') }}" class="btn btn-outline-info float-right mr-2"><i class="fas fa-print mr-2"></i>Cetak Pembimbing Siswa</a>
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
          <th>Wilayah</th>
          <th>Guru</th>
          <th>Siswa</th>
          <th style="width: 10%">Aksi</th>
        </tr>
        </thead>
        <tbody>
          @for ($i = 0; $i < count($mentor); $i++)
            <tr>
              <td class="align-middle">{{ $i + 1 }}</td>
              <td class="align-middle">
                {{ $mentor[$i]['region'] }} <br>
                {{ $mentor[$i]['city'] }}
              </td>
              <td class="align-middle">
                {{ $mentor[$i]['teacher'] }} <br>
                {{ $mentor[$i]['nip'] }} <br>
                {{ $mentor[$i]['teacher_department'] }}
              </td>
              <td class="align-middle">
                {{ $mentor[$i]['student'] }} <br>
                {{ $mentor[$i]['nisn'] }} <br>
                {{ $mentor[$i]['student_grade'] . ' ' . $mentor[$i]['student_department'] }}
              </td>
              <td class="text-center align-middle">
                <a href="" class="badge bg-secondary" onclick="getMentoringById({{ $mentor[$i]['mentor_id'] }})" data-toggle="modal" data-target="#modal-edit">Ubah</a>
                <a href="#" class="badge bg-danger" onclick="deleteItem('{{ route('mentoring-delete', ['id' => $mentor[$i]['mentor_id']]) }}')">Hapus</a>
              </td>
            </tr>
          @endfor
        </tbody>
      </table>
    </div>
  </div>

  {{-- Modal Edit --}}
  <div class="modal fade" id="modal-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ubah Data Pembimbing Siswa</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" id="form-edit" method="POST" class="px-3">
                @method('put')
                @csrf

                <div class="form-group invisible">
                    <input type="hidden" class="form-control" id="mentoring-id" readonly>
                </div>
                <div class="form-group">
                  <label>Guru Pembimbing</label>
                  <select class="custom-select" name="mentor_id" id="mentor-dropdown">
                  </select>
              </div>
              <div class="form-group">
                  <label>Murid</label>
                  <select class="custom-select" name="student_id" id="student-dropdown">
                  </select>
              </div>
                <div class="modal-footer align-right mt-2 pt-2">
                  <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-chevron-left mr-1"></i> Batal</a>
                  <button type="submit" class="btn btn-primary" onclick="editMentoring()"><i class="fa fa-save fa-sm mr-1"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
  </div>

  <script src="{{ asset('js/mentor/mentoring.js') }}"></script>
@endsection