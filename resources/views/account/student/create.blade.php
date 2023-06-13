@extends('layout.app')

@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title mt-2">Tambah Akun Siswa</h3>
    </div>
    <div class="card-body">
      @if(Session::has('error'))
        <div class="alert alert-danger">{{ Session::get('error') }}</div>
      @endif
      <form action="{{ $method == "create" ? route('student-store') : route('student-update', ['id' => $student->id]) }}"  method="POST">
        @csrf
        @if($method == "edit")
          @method('PUT')
        @endif

        <div class="row">
            <div class="col -6">
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ $student->name ?? old('name') ?? '' }}" placeholder="Nama Lengkap Siswa" name="name">
                    @error('name')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>NISN</label>
                    <input type="number" class="form-control @error('nisn') is-invalid @enderror" value="{{ $student->nisn ?? old('nisn') ?? '' }}" placeholder="NISN Siswa" name="nisn">
                    @error('nisn')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                </div>
                <div class="form-group">
                  <label>Kelas</label>
                  <select class="custom-select" name="class_id" id="class-dropdown">
                    @foreach ($class as $data)
                      <option value="{{ $data->id }}" @if($method == "edit") @if($data->id == $student->grade_class_id) selected @endif @endif>
                        {{ $data->grade. " - ". $data->department->name }}
                      </option>
                    @endforeach
                  </select>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" value="{{ $student->user->email ?? old('email') ?? '' }}" placeholder="Email Akun Siswa" name="email">
                    @error('email')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" placeholder="Password Akun" name="password">
                    @error('password')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Konfirmasi Password</label>
                    <input type="password" class="form-control @error('confirmation_password') is-invalid @enderror" placeholder="Ulangi Kembali Password Akun" name="confirmation_password">
                    @error('confirmation_password')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="modal-footer align-right mt-2 pt-2">
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-chevron-left mr-1"></i> Batal</a>
          <button type="submit" class="btn btn-primary"><i class="fa fa-save fa-sm mr-1"></i> Simpan</button>
        </div>
    </form>
    </div>
  </div>
@endsection