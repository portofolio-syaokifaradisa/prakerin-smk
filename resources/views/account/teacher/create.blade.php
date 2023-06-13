@extends('layout.app')

@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title mt-2">Tambah Akun Guru</h3>
    </div>
    <div class="card-body">
      @if(Session::has('error'))
        <div class="alert alert-danger">{{ Session::get('error') }}</div>
      @endif
      <form action="{{ $method == "create" ? route('teacher-store') : route('teacher-update', ['id' => $teacher->id]) }}"  method="POST">
        @csrf
        @if($method == "edit")
          @method('PUT')
        @endif

        <div class="row">
            <div class="col -6">
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ $teacher->name ?? old('name') ?? '' }}" placeholder="Nama Lengkap Guru" name="name">
                    @error('name')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>NIP</label>
                    <input type="number" class="form-control @error('nip') is-invalid @enderror" value="{{ $teacher->nip ?? old('nip') ?? ''}}" placeholder="NIP Guru" name="nip">
                    @error('nip')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                </div>
                <div class="form-group">
                  <label>Jabatan</label>
                  <input type="text" class="form-control @error('position') is-invalid @enderror" value="{{ $teacher->position ?? old('position') ?? '' }}" placeholder="Jabatan Guru" name="position">
                  @error('position')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
              <div class="form-group">
                <label>Kelas</label>
                <select class="custom-select @error('class_id') is-invalid @enderror" name="class_id" id="class-dropdown">
                  @foreach ($class as $data)
                    <option value="{{ $data->id }}" @if($method == "edit") @if($data->id == $teacher->grade_class_id) selected @endif @endif>
                      {{ $data->grade. " - ". $data->department->name }}
                    </option>
                  @endforeach
                </select>
                @error('class_id')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" value="{{ $teacher->user->email ?? old('email') ?? '' }}" placeholder="Email Akun Guru" name="email">
                    @error('email')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password Akun" name="password">
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