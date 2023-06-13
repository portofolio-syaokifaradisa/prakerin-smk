@extends('layout.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title mt-2">Data Kelas</h3>
        <a href="{{ route('class-create') }}" class="btn btn-sm btn-primary float-right px-3"><i class="fas fa-plus mr-2"></i>Tambah Kelas</a>
    </div>
    <div class="card-body">
        @if (Session::has('class-success'))
            <div class="alert alert-success">{{ Session::get('class-success') }}</div>
        @elseif(Session::has('class-error'))
            <div class="alert alert-danger">{{ Session::get('class-error') }}</div>
        @endif
        <table class="datatables table table-bordered table-striped">
        <thead>
        <tr>
            <th style="width: 7%">No</th>
            <th style="width: 10%">Tingkatan</th>
            <th>Jurusan</th>
            <th style="width: 10%">Aksi</th>
        </tr>
        </thead>
        <tbody>
            @for ($i = 0; $i < count($classes); $i++)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $classes[$i]->grade }}</td>
                <td>{{ $classes[$i]->Department->name }}</td>
                <td class="text-center">
                    <a href="{{ route('class-edit', ['id' => $classes[$i]->id]) }}" class="badge bg-secondary">Ubah</a>
                    <a href="#" class="badge bg-danger" onclick="deleteItem('{{ route('class-delete', ['id' => $classes[$i]->id]) }}')">Hapus</a>
                </td>
            </tr>
            @endfor
        </tbody>
        </table>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title mt-2">Data jurusan</h3>
        <a href="{{ route('department-create') }}" class="btn btn-sm btn-primary float-right px-3"><i class="fas fa-plus mr-2"></i>Tambah Jurusan</a>
    </div>
    <div class="card-body">
        @if (Session::has('department-success'))
            <div class="alert alert-success">{{ Session::get('department-success') }}</div>
        @elseif(Session::has('department-error'))
            <div class="alert alert-danger">{{ Session::get('department-error') }}</div>
        @endif
        <table class="datatables table table-bordered table-striped">
            <thead>
            <tr>
                <th style="width: 7%">No</th>
                <th>Tingkat</th>
                <th style="width: 10%">Aksi</th>
            </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < count($departments); $i++)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $departments[$i]->name }}</td>
                    <td class="text-center">
                        <a href="{{ route('department-edit', ['id' => $departments[$i]->id]) }}" class="badge bg-secondary">Ubah</a>
                        <a href="#" class="badge bg-danger" onclick="deleteItem('{{ route('department-delete', ['id' => $departments[$i]->id]) }}')">Hapus</a>
                    </td>
                </tr>
                @endfor
            </tbody>
        </table>
    </div>
</div>

@include('gradeClass.modals')

<script src="{{ asset('js/gradeClass/department.js') }}"></script>
<script src="{{ asset('js/gradeClass/class.js') }}"></script>

@endsection