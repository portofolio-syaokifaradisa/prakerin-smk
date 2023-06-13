@extends('layout.app')

@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title mt-2">Data Wilayah Instansi</h3>
    </div>
    <div class="card-body">
      @if(Session::has('error'))
        <div class="alert alert-danger">{{ Session::get('error') }}</div>
      @endif
      <form action="{{ $method == "create" ? route('agency') : route('agency-update', ['id' => $agency->id]) }}" method="POST" class="px-3">
        @csrf
        @if($method == "edit")
          @method('PUT')
        @endif
        <div class="row">
          <div class="col-6">
            <div class="form-group">
              <label>Nama Instansi</label>
              <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ $agency->name ?? old('name') ?? '' }}" placeholder="Nama Instansi" name="name">
              @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
            <div class="form-group">
              <label>Wilayah</label>
              <select class="custom-select" name="region_id">
                @foreach ($region as $data)
                  <option value="{{ $data->id }}">
                    {{ $data->name}} | {{ $data->city }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label>Nomor Telepon Instansi</label>
              <input type="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ $agency->phone ?? old('phone') ?? '' }}" placeholder="Nomor Telepon Instansi" name="phone">
              @error('phone')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
          </div>
          <div class="col-6">
            <div class="form-group">
              <label>Pimpinan</label>
              <input type="text" class="form-control @error('leader') is-invalid @enderror" value="{{ $agency->leader ?? old('leader') ?? '' }}" placeholder="Pimpinan Instansi" name="leader">
              @error('leader')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
            <div class="form-group">
              <label>NIP Pimpinan</label>
              <input type="number" class="form-control @error('nip') is-invalid @enderror" value="{{ $agency->nip ?? old('nip') ?? '' }}" placeholder="NIP Pimpinan Instansi" name="nip">
              <small class="text-danger">*Kosongkan Jika Tidak Mempunyai NIP</small>
              @error('nip')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
          </div>
        </div>
        <div class="row">
          <div class="form-group col">
            <label>Alamat</label>
            <textarea class="form-control @error('address') is-invalid @enderror"rows="3" placeholder="Alamat Instansi" name="address">{{ $agency->address ?? old('address') ?? '' }}</textarea>
            @error('address')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
          <div class="form-group col">
            <label>Karakteristik</label>
            <textarea class="form-control @error('characteristic') is-invalid @enderror" rows="3" placeholder="Karakteristik Instansi (Pisahkan dengan koma)" name="characteristic">{{ $agency->characteristic ?? old('characteristic') ?? '' }}</textarea>
            @error('characteristic')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
        </div>
        <div class="modal-footer align-right mt-2 pt-2">
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-chevron-left mr-1"></i> Batal</a>
          <button type="submit" class="btn btn-primary" onclick=""><i class="fa fa-save fa-sm mr-1"></i> Simpan</button>
        </div>
    </form>
    </div>
  </div>
@endsection