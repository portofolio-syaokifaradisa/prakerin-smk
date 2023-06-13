@extends('layout.app')

@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title mt-2">Tambah Akun Admin</h3>
    </div>
    <div class="card-body">
      @if(Session::has('error'))
        <div class="alert alert-danger">{{ Session::get('error') }}</div>
      @endif
      <form action="{{ $method == "create" ? route('admin-store') : route('admin-update', ['id' => $admin->id]) }}"  method="POST">
        @csrf
        @if ($method == "edit")
          @method('PUT')
        @endif

        <div class="row">
            <div class="col -6">
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ $admin->name ?? old('name') ?? '' }}" placeholder="Nama Lengkap Pemegang Akun" name="name">
                    @error('name')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" value="{{ $admin->user->email ?? old('email') ?? '' }}" placeholder="Email Akun Admin Baru" name="email">
                    @error('email')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                </div>
            </div>
            <div class="col-6">
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