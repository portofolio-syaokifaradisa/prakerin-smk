@extends('layout.app')

@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title mt-2">Data Instansi</h3>
      @if (Auth::user()->role != "STUDENT" && Auth::user()->role != "TEACHER")
        <a href="{{ route('agency-create') }}" class="btn btn-primary float-right px-3">
          <i class="fas fa-plus mr-2"></i>
          Tambah Instansi
        </a>
      @endif
      <a href="{{ route('agency-print') }}" class="btn btn-outline-info float-right mr-2"><i class="fas fa-print mr-2"></i>Cetak Instansi Magang</a>
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
          <th style="width: 5%">No</th>
          <th>Instansi</th>
          <th>Pimpinan</th>
          <th>Alamat</th>
          <th>Karakteristik</th>
          @if (Auth::user()->role != "STUDENT" && Auth::user()->role != "TEACHER")
            <th style="width: 10%">Aksi</th>
          @endif
        </tr>
        </thead>
        <tbody>
          @for ($i = 0; $i < count($agency); $i++)
            <tr>
              <td class="text-center align-middle">{{ $i + 1 }}</td>
              <td class="align-middle">
                {{ $agency[$i]->name }} <br>
                {{ $agency[$i]->Region->name }}
              </td>
              <td class="align-middle">
                {{ $agency[$i]->leader }} <br>
                {{ $agency[$i]->nip }} <br>
                {{ $agency[$i]->phone }}
              </td>
              <td class="align-middle">{{ $agency[$i]->address }}</td>
              <td class="align-middle">
                <ol>
                  @foreach (explode(',', $agency[$i]->characteristic) as $data)
                    <li>
                      {{ trim($data) }}
                    </li>
                  @endforeach
                </ol>
              </td>
              @if (Auth::user()->role != "STUDENT" && Auth::user()->role != "TEACHER")
                <td class="text-center align-middle">
                  <a href="{{ route('agency.edit', ['id' => $agency[$i]->id]) }}" class="badge bg-secondary">Ubah</a>
                  <a href="#" class="badge bg-danger" onclick="deleteItem('{{ route('agency-delete', ['id' => $agency[$i]->id]) }}')">Hapus</a>
                </td>
              @endif
            </tr>
          @endfor
        </tbody>
      </table>
    </div>
  </div>

  <script>
    function editAgency(){
      var agency_id = $('#agency-id').val();
      $('#form-edit').attr('action', '/agency/' + agency_id);

      $('#form-edit').unbind("submit");
      $('#form-edit').submit();
    }

    function getAgencyById(id){
      $.ajax({
        url : "/agency/" + id,
        type : "GET",
        success: function(agency){
            var agencyData = JSON.parse(agency);

            $('#agency-id').val(agencyData.id);
            $('#name').val(agencyData.name);
            $('#region').val(agencyData.region_id);
            $('#address').html(agencyData.address);
            $('#characteristic').html(agencyData.characteristic);
            $('#phone').val(agencyData.phone);
            $('#name').val(agencyData.name);
            $('#leader').val(agencyData.leader);
            $('#nip').val(agencyData.nip);
        }
      });
    }
  </script>
@endsection