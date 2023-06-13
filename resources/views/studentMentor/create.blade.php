@extends('layout.app')

@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title mt-2">Menentukan Guru Pembimbing Siswa</h3>
    </div>
    <div class="card-body">
      @if(Session::has('error'))
        <div class="alert alert-danger">{{ Session::get('error') }}</div>
      @endif
      <form action="{{ route('mentoring') }}" method="POST" class="px-3">
        @csrf
        <div class="form-group">
            <label>Guru</label>
            <select class="custom-select" name="mentor_id">
                @foreach ($mentor as $data)
                    <option value="{{ $data->id }}">{{ $data->teacher->name . ' - ' . $data->region->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Murid</label>
            <select class="custom-select" name="student_id">
                @foreach ($student as $data)
                    <option value="{{ $data->id }}">{{ $data->name .' - ' . $data->nisn}}</option>
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