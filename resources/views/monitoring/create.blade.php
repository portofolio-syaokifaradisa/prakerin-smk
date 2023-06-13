@extends('layout.app')

@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title mt-2">Pelaporan Kegiatan</h3>
    </div>
    <form action="@if (isset($monitoring)) 
        {{ route("app-letter.monitoring.update", ['id' => $app_letter_id, 'monitoring_id' => $monitoring->id]) }} 
      @else 
        {{ route("app-letter.monitoring.store", ['id' => $app_letter_id]) }} 
      @endif" method="post">
      @csrf
      
      @if(isset($monitoring))
        @method('PUT')
      @endif

      <div class="card-body">
        @if (Session::has('success'))
          <div class="alert alert-success">{{ Session::get('success') }}</div>
        @elseif(Session::has('error'))
          <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif
        
        <div class="form-group">
          <label>Tanggal Monitoring</label>
            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                <input name="monitoring_date" type="text" class="form-control datetimepicker-input" data-target="#reservationdate" value="{{ date('m-d-Y', strtotime($journal->date ?? now())) }}"/>
                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
            </div>
            <div class="form-group mt-4">
              <label>Isi Monitoring</label>
              <textarea name="monitoring" class="form-control" rows="3" placeholder="Masukkan Isi Monitoring yang Dilakukan">{{ $monitoring->description ?? '' }}</textarea>
            </div>
        </div>
      </div>
      <div class="modal-footer align-right mt-2 pt-2">
        <a class="btn btn-default" href="{{ route('app-letter.monitoring.index', ['id' => $app_letter_id]) }}">
          <i class="fa fa-chevron-left mr-1">
            </i> Batal
        </a>
        <button type="submit" class="btn btn-primary"><i class="fa fa-save fa-sm mr-1"></i> Simpan</button>
      </div>
    </form>
  </div>
@endsection