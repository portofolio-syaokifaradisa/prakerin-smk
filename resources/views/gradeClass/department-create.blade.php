@extends('layout.app')

@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title mt-2">Tambah Data Wilayah Instansi</h3>
    </div>
    <div class="card-body">
      @if(Session::has('error'))
        <div class="alert alert-danger">{{ Session::get('error') }}</div>
      @endif
      <form action="{{ $method == "create" ? route('department-store') : route('department-update', ['id' => $department->id]) }}" method="POST">
        @csrf
        @if ($method == "edit")
          @method('PUT')
        @endif

        <div class="form-group">
            <label>Nama Jurusan</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ $department->name ?? old('name') ?? '' }}" placeholder="Nama Jurusan Baru" name="name">
            @error('name')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
            @enderror
        </div>
        <div class="modal-footer align-right mt-2 pt-2">
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-chevron-left mr-1"></i> Batal</a>
          <button type="submit" class="btn btn-primary"><i class="fa fa-save fa-sm mr-1"></i> Simpan</button>
        </div>
    </form>
    </div>
  </div>
@endsection