@extends('layout.app')

@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title mt-2">Evaluasi {{ $student->name }}</h3>
    </div>
    <div class="card-body">
      @if(Session::has('error'))
        <div class="alert alert-danger">{{ Session::get('error') }}</div>
      @endif
      <form action="@if ($student->evaluation)
            {{ route('evaluation.update', ['studentId' => $student->id]) }}  
        @else
            {{ route('evaluation.store', ['studentId' => $student->id]) }}  
        @endif" 
        method="POST" class="px-3">
        
        @csrf
        @if ($student->evaluation)
            @method('PUT')
        @endif

        <div class="row">
            <div class="form-group col">
                <label>Pengetahuan Teori</label>
                <input type="text" class="form-control @error('teori') is-invalid @enderror" value="{{ $student->evaluation->teori ?? old('teori') ?? ''}}" name="teori">
            </div>
            <div class="form-group col">
                <label>Keterampilan Dasar</label>
                <input type="text" class="form-control @error('keterampilan') is-invalid @enderror" value="{{ $student->evaluation->keterampilan ?? old('keterampilan') ?? ''}}" name="keterampilan">
                @error('name')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="form-group col">
                <label>Keselamatan Kerja</label>
                <input type="text" class="form-control @error('keselamatan') is-invalid @enderror" value="{{ $student->evaluation->keselamatan ?? old('keselamatan') ?? ''}}" name="keselamatan">
            </div>
            <div class="form-group col">
                <label>Disiplin Kerja</label>
                <input type="text" class="form-control @error('disiplin') is-invalid @enderror" value="{{ $student->evaluation->disiplin ?? old('disiplin') ?? ''}}"name="disiplin">
            </div>
        </div>
        <div class="form-group">
            <label>Sikap dan Tanggung Jawab</label>
            <input type="text" class="form-control @error('sikap') is-invalid @enderror" value="{{ $student->evaluation->sikap ?? old('sikap') ?? ''}}" name="sikap">
        </div>
        <div class="modal-footer align-right mt-2 pt-2">
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-chevron-left mr-1"></i> Batal</a>
          <button type="submit" class="btn btn-primary" onclick=""><i class="fa fa-save fa-sm mr-1"></i> Simpan</button>
        </div>
    </form>
    </div>
  </div>
@endsection