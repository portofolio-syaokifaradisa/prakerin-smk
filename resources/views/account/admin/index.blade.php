@extends('layout.app')

@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title mt-2">Data Akun Admin</h3>
      <a href="{{ route('admin-create') }}" class="btn btn-primary float-right px-3"><i class="fas fa-plus mr-2"></i>Tambah Admin</a>
      <a href="{{ route('admin-print') }}" class="btn btn-outline-info float-right mr-2"><i class="fas fa-print mr-2"></i>Cetak Akun Admin</a>
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
          <th>Nama Pemegang Akun</th>
          <th>Email</th>
          <th>Tanggal Pembuatan</th>
          <th style="width: 10%">Aksi</th>
        </tr>
        </thead>
        <tbody>
          @for ($i = 0; $i < count($user); $i++)
            <tr>
              <td>{{ $i + 1 }}</td>
              <td>{{ $user[$i]->Information->name }}</td>
              <td>{{ $user[$i]->email }}</td>
              <td>{{ $user[$i]->created_at }}</td>
              <td class="text-center">
                <a href="{{ route('admin-edit', ['id' => $user[$i]->id]) }}" class="badge bg-secondary">Ubah</a>
                <a href="#" class="badge bg-danger" onclick="deleteItem('{{ route('admin-delete', ['id' => $user[$i]->id]) }}')">Hapus</a>
              </td>
            </tr>
          @endfor
        </tbody>
      </table>
    </div>
  </div>

  <script src="{{ asset('js/account/admin.js') }}"></script>
@endsection