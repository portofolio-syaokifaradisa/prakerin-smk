@extends('layout.app')

@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title mt-2">Tambah Data Kelas</h3>
    </div>
    <div class="card-body">
      @if(Session::has('error'))
        <div class="alert alert-danger">{{ Session::get('error') }}</div>
      @endif
      <form action="{{ $method == "create" ? route('class-store') : route('class-update', ['id' => $gradeClass->id])}}" method="POST">
        @csrf
        @if ($method == "edit")
          @method('PUT')
        @endif

        <div class="form-group">
            <label>Tingkatan</label>
            <select class="custom-select" name="grade">
                <option value="10" @if($gradeClass->grade == "10") selected @endif>10</option>
                <option value="11" @if($gradeClass->grade == "11") selected @endif>11</option>
                <option value="12" @if($gradeClass->grade == "12") selected @endif>12</option>
            </select>
        </div>
        <div class="form-group">
            <label>Jurusan</label>
            <select class="custom-select" name="department_id">
                @foreach ($departments as $data)
                    <option value="{{ $data->id }}" @if($data->id == $gradeClass->department_id) selected @endif>
                      {{ $data->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="modal-footer align-right mt-2 pt-2">
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-chevron-left mr-1"></i> Batal</a>
          <button type="submit" class="btn btn-primary"><i class="fa fa-save fa-sm mr-1"></i> Simpan</button>
        </div>
    </form>
    </div>
  </div>
@endsection