@extends('layout.app')

@section('content')
@if (Session::has('success'))
  <div class="alert alert-success">{{ Session::get('success') }}</div>
@elseif(Session::has('error'))
  <div class="alert alert-danger">{{ Session::get('error') }}</div>
@endif
<div class="card">
    <div class="card-header">
      <h3 class="card-title mt-2">Pengajuan Surat Permohonan</h3>
    </div>
    <div class="card-body">
      <form action="{{ route('app-letter-store') }}" method="post">
        @csrf
        <div class="form-group">
          <label>Instansi</label>
          <select class="custom-select" name="agency_id">
            @foreach ($agency as $data)
              <option value="{{ $data->id }}">{{ $data->name . " - " . $data->Region->name . " (" . $data->current_limit . "/".$data->limit .")"}}</option>
            @endforeach
          </select>
        </div>
        <div class="modal-footer align-right mt-2 pt-2">
          <a type="button" class="btn btn-default" href="{{ route('class') }}"><i class="fa fa-chevron-left mr-1"></i> Kembali</a>
          <button type="submit" class="btn btn-primary"><i class="fa fa-save fa-sm mr-1"></i> Ajukan</button>
        </div>
     </form>
    </div>
  </div>
@endsection