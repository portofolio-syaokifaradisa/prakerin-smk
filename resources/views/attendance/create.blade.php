@extends('layout.app')

@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title mt-2">Form Konfirmasi {{ ucwords($type) }} Magang</h3>
    </div>
    <div class="card-body">
      @if(Session::has('error'))
        <div class="alert alert-danger">{{ Session::get('error') }}</div>
      @endif
      <form action="{{ route('app-letter.attedance.store', ['id' => $app_letter_id, 'type' => $type]) }}" method="POST" class="px-3">
        @csrf
        <div class="form-group">
            <label>Alasan</label>
            <textarea class="form-control" rows="3" placeholder="Alasan {{ ucwords($type) }}" name="description"></textarea>
        </div>
        <div class="modal-footer align-right mt-2 pt-2">
          <a href="{{ route('app-letter.journal.index', ['id' => $app_letter_id]) }}" class="btn btn-default" ><i class="fa fa-chevron-left mr-1"></i> Batal</a>
          <button type="submit" class="btn btn-primary"><i class="fa fa-save fa-sm mr-1"></i> Simpan</button>
        </div>
    </form>
    </div>
  </div>
@endsection