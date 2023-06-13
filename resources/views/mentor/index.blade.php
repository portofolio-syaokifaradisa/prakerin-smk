@extends('layout.app')

@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title mt-2">Data Wilayah Instansi</h3>
      <a href="{{ route('mentor-create') }}" class="btn btn-primary float-right px-3"><i class="fas fa-plus mr-2"></i>Tambah Guru Pembimbing</a>
      <a href="{{ route('mentor-print') }}" class="btn btn-outline-info float-right mr-2"><i class="fas fa-print mr-2"></i>Cetak Pembimbing</a>
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
          <th>NIP</th>
          <th>Nama Guru</th>
          <th>Jurusan</th>
          <th>Wilayah</th>
          <th style="width: 10%">Aksi</th>
        </tr>
        </thead>
        <tbody>
          @for ($i = 0; $i < count($mentor); $i++)
            <tr>
              <td>{{ $i + 1 }}</td>
              <td>{{ $mentor[$i]->Teacher->nip }}</td>
              <td>{{ $mentor[$i]->Teacher->name }}</td>
              <td>{{ $mentor[$i]->Teacher->grade_class->Department->name }}</td>
              <td>{{ $mentor[$i]->region->name }}</td>
              <td class="text-center">
                <a href="" class="badge bg-secondary" onclick="getMentorById({{ $mentor[$i]->id }})" data-toggle="modal" data-target="#modal-edit">Ubah</a>
                <a href="#" class="badge bg-danger" onclick="deleteItem('{{ route('mentor-delete', ['id' => $mentor[$i]->id]) }}')">Hapus</a>
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
                <h4 class="modal-title">Ubah Data Pembimbing</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" id="form-edit" method="POST" class="px-3">
                @method('put')
                @csrf

                <div class="form-group invisible">
                    <input type="hidden" class="form-control" id="mentor-id" readonly>
                </div>
                <div class="form-group">
                    <label>Guru</label>
                    <select class="custom-select" name="teacher_id" id="teacher-dropdown">
                    </select>
                </div>
                <div class="form-group">
                    <label>Wilayah</label>
                    <select class="custom-select" name="region_id" id="region-dropdown">
                    </select>
                </div>
                <div class="modal-footer align-right mt-2 pt-2">
                  <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-chevron-left mr-1"></i> Batal</a>
                  <button type="submit" class="btn btn-primary" onclick="editMentor()"><i class="fa fa-save fa-sm mr-1"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
  </div>

  <script src="{{ asset('js/mentor/mentor.js') }}"></script>
@endsection