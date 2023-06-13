@extends('layout.app')

@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title mt-2">Data Wilayah Instansi</h3>
      @if (Auth::user()->role != "STUDENT" && Auth::user()->role != "TEACHER")
        <a href="{{ route('region-create') }}" class="btn btn-primary float-right px-3">
          <i class="fas fa-plus mr-2"></i>
          Tambah Wilayah
        </a>
      @endif
      <a href="{{ route('region-print') }}" class="btn btn-outline-info float-right mr-2">
        <i class="fas fa-print mr-2"></i>
        Cetak Wilayah Magang
      </a>
    </div>
    <div class="card-body">
      @if (Session::has('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
      @elseif(Session::has('error'))
        <div class="alert alert-danger">{{ Session::get('error') }}</div>
      @endif
      <table class="datatables table table-bordered table-striped">
        <thead>
        <tr>
          <th style="width: 7%">No</th>
          <th>Wilayah </th>
          <th>Kota</th>
          @if (Auth::user()->role != "STUDENT" && Auth::user()->role != "TEACHER")
            <th style="width: 10%">Aksi</th>    
          @endif
        </tr>
        </thead>
        <tbody>
          @for ($i = 0; $i < count($region); $i++)
            <tr>
              <td>{{ $i + 1 }}</td>
              <td>{{ $region[$i]->name }}</td>
              <td>{{ $region[$i]->city }}</td>
              @if (Auth::user()->role != "STUDENT" && Auth::user()->role != "TEACHER")
                <td class="text-center">
                  <a href="{{ route('region.edit', ['id' => $region[$i]->id]) }}" class="badge bg-secondary">Ubah</a>
                  <a href="#" class="badge bg-danger" onclick="deleteItem('{{ route('region-delete', ['id' => $region[$i]->id]) }}')">Hapus</a>
                </td>
              @endif
            </tr>
          @endfor
        </tbody>
      </table>
    </div>
  </div>
@endsection

