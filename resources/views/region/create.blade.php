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
      <form action="{{ $method == "create" ? route('region-store') : route('region-update', ['id' => $region->id]) }}" id="form-edit" method="POST">
        @csrf
        @if($method == "edit")
          @method('PUT')
        @endif

        <div class="row">
          <div class="form-group col">
            <label>Nama Wilayah Instansi</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ $region->name ?? old('name') ?? ''}}" placeholder="Nama Wilayah Tempat Instansi" name="name" id="name">
            @error('name')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
          <div class="form-group col">
            <label>kota Instansi</label>
            <input type="text" class="form-control @error('city') is-invalid @enderror" value="{{ $region->city ?? old('city') ?? '' }}" placeholder="Kota Tempat Instansi" name="city" id="city">
            @error('city')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
            @enderror
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