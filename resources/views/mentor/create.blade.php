@extends('layout.app')

@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title mt-2">Tambah Guru Pembimbing</h3>
    </div>
    <div class="card-body">
      @if(Session::has('error'))
        <div class="alert alert-danger">{{ Session::get('error') }}</div>
      @endif
      <form action="{{ route('mentor') }}" method="POST" class="px-3">
        @csrf
        <div class="form-group">
            <label>Guru</label>
            <select class="custom-select" name="teacher_id">
                @foreach ($teacher as $data)
                <option value="{{ $data->id }}">{{ $data->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Wilayah</label>
            <select class="custom-select" name="region_id">
                @foreach ($region as $data)
                <option value="{{ $data->id }}">{{ $data->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="modal-footer align-right mt-2 pt-2">
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-chevron-left mr-1"></i> Batal</a>
          <button type="submit" class="btn btn-primary" onclick=""><i class="fa fa-save fa-sm mr-1"></i> Simpan</button>
        </div>
    </form>
    </div>
  </div>
@endsection