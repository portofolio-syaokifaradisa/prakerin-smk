@extends('layout.app')

@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title mt-2">Data Akun Guru</h3>
      <a href="{{ route('teacher-create') }}" class="btn btn-primary float-right px-3"><i class="fas fa-plus mr-2"></i>Tambah Guru</a>
      <a href="{{ route('teacher-print') }}" class="btn btn-outline-info float-right mr-2"><i class="fas fa-print mr-2"></i>Cetak Akun Guru</a>
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
          <th>Nama lengkap</th>
          <th>NIP</th>
          <th>Jabatan</th>
          <th>Email</th>
          <th>Tanggal Pembuatan</th>
          <th style="width: 10%">Aksi</th>
        </tr>
        </thead>
        <tbody>
          @for ($i = 0; $i < count($teacher); $i++)
            <tr>
              <td>{{ $i + 1 }}</td>
              <td>{{ $teacher[$i]->name }}</td>
              <td>{{ $teacher[$i]->nip }}</td>
              <td>{{ $teacher[$i]->position }}</td>
              <td>{{ $teacher[$i]->email }}</td>
              <td>{{ $teacher[$i]->date }}</td>
              <td class="text-center">
                <a href="{{ route('teacher-edit', ['id' => $teacher[$i]->id]) }}" class="badge bg-secondary">Ubah</a>
                <a href="#" class="badge bg-danger" onclick="deleteItem('{{ route('teacher-delete', ['id' => $teacher[$i]->id]) }}')">Hapus</a>
              </td>
            </tr>
          @endfor
        </tbody>
      </table>
    </div>
  </div>

  <div class="modal fade" id="modal-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ubah Data Wilayah</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action=""  method="POST" class="px-3" id="form-edit">
                @method('put')
                @csrf

                <div class="form-group invisible">
                    <input type="hidden" class="form-control" id="teacher-id" readonly>
                </div>
                <div class="row">
                  <div class="col -6">
                      <div class="form-group">
                          <label>Nama Lengkap</label>
                          <input type="text" class="form-control" placeholder="Nama Lengkap Guru" name="name" id="name">
                      </div>
                      <div class="form-group">
                          <label>NIP</label>
                          <input type="number" class="form-control" placeholder="NIP Guru" name="nip" id="nip">
                      </div>
                      <div class="form-group">
                        <label>Jabatan</label>
                        <input type="text" class="form-control" placeholder="Jabatan Guru" name="position" id="position">
                    </div>
                  </div>
                  <div class="col-6">
                      <div class="form-group">
                          <label>Email</label>
                          <input type="email" class="form-control" placeholder="Email Akun Guru" name="email" id="email">
                      </div>
                      <div class="form-group">
                          <label>Password</label>
                          <input type="password" class="form-control" placeholder="Password Akun" name="password">
                      </div>
                      <div class="form-group">
                          <label>Konfirmasi Password</label>
                          <input type="password" class="form-control" placeholder="Ulangi Kembali Password Akun" name="confirmation_password">
                      </div>
                  </div>
                </div>
                <div class="modal-footer align-right mt-2 pt-2">
                  <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-chevron-left mr-1"></i> Batal</a>
                  <button type="submit" class="btn btn-primary" onclick="editStudent()"><i class="fa fa-save fa-sm mr-1"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
  </div>

  <script src="{{ asset('js/account/teacher.js') }}"></script>
@endsection