@extends('layout.app')

@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title mt-2">Data Surat Permohonan</h3>
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
          <th>No</th>
          <th>Instansi</th>
          <th>Pimpinan</th>
          <th>Wilayah</th>
          <th>Siswa</th>
          <th>Tahun</th>
          <th>Status</th>
          <th style="width: 10%">Aksi</th>
        </tr>
        </thead>
        <tbody>
            <?php $i=1; ?>
            @foreach ($letter as $general_data)
            <tr>
                <td class="align-middle">{{ $i }}</td>
                <td class="align-middle">{{ $general_data->first()->agency->name }}</td>
                <td class="align-middle">{{ $general_data->first()->agency->leader }}</td>
                <td class="align-middle">{{ $general_data->first()->agency->region->name }}</td>
                <td class="align-middle">
                    <ul class="ml-0">
                        @foreach ($general_data as $data)
                            <li>{{ $data->student->name }}</li>
                        @endforeach
                    </>
                </td>
                <td class="align-middle">{{ date('Y', strtotime($general_data->first()->created_at)) }}</td>
                <td class="text-center align-middle">
                    @if ($general_data->first()->status == "DELIVERED")
                        <span class="badge bg-primary">Terkirim</span>
                    @elseif ($general_data->first()->status == "PENDING")
                        <span class="badge bg-warning">Diproses</span>
                    @else
                        <span class="badge bg-success">Selesai</span>
                    @endif
                </td>
                <td class="text-center align-middle">
                    @if ($general_data->first()->status == "DELIVERED")
                        <a href="" onclick="setDataToFinalModal({{ $general_data->first()->agency_id.'.'. date('Y', strtotime($general_data->first()->created_at))}})" class="badge bg-primary" data-toggle="modal" data-target="#modal-accept" title="Terima">Terima</a>
                    @elseif ($general_data->first()->status == "PENDING")
                        <a href="" onclick="setDataToFinalModal({{ $general_data->first()->agency_id.'.'. date('Y', strtotime($general_data->first()->created_at))}})" class="badge bg-warning" data-toggle="modal" data-target="#modal-complete" title="Selesaikan">Selesaikan</a>
                    @endif

                    @if ($general_data->first()->status != "DELIVERED")
                        <a href="{{ route('request-letter', ['data' => $general_data->first()->agency_id.'.'. date('Y', strtotime($general_data->first()->created_at))]) }}}}" class="badge bg-secondary px-2 py-1"><i class="fas fa-print mr-1"></i>Permohonan</a>
                        <a href="{{ route('introduction-letter', ['data' => $general_data->first()->agency_id.'.'. date('Y', strtotime($general_data->first()->created_at))]) }}}}" class="badge bg-secondary px-2 py-1"><i class="fas fa-print mr-1"></i>Pengantar</a>
                        <a href="{{ route('colaboration-letter', ['id' => $general_data->first()->agency->id]) }}}}" class="badge bg-secondary px-2 py-1"><i class="fas fa-print mr-1"></i>kerjasama</a>
                    @endif
                </td>
            </tr>
            <?php $i++; ?>
            @endforeach
        </tbody>
      </table>
    </div>
  </div>

  {{-- Modal Terima Surat --}}
  <div class="modal fade" id="modal-accept" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Konfirmasi Penerimaan Pengajuan Surat</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
              <form action="#" id="form-accept" method="POST" class="px-3">
                @csrf
                {{ method_field('put') }}

                <div class="modal-body">
                  <div class="form-group invisible">
                      <input type="hidden" class="form-control" id="letter-data" readonly>
                  </div>
                  <div class="form-group">
                    <label>Tanggal Ajuan Magang</label>

                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="far fa-calendar-alt"></i>
                        </span>
                      </div>
                      <input type="text" class="form-control float-right" id="reservation" name="date_range">
                    </div>
                    <!-- /.input group -->
                  </div>
                </div>
                <div class="modal-footer align-right mt-2 pt-2">
                  <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-chevron-left mr-1"></i> Batal</a>
                  <button type="submit" class="btn btn-primary" onclick="acceptLetter()"><i class="fa fa-save fa-sm mr-1"></i> Terima</button>
                </div>
            </form>
            
        </div>
    </div>
  </div>

  {{-- Modal Selesaikan Surat --}}
  <div class="modal fade" id="modal-complete" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Konfirmasi Penyelesaian Surat</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" id="form-complete" method="POST" class="px-3">
              @csrf
              {{ method_field('put') }}

              <div class="form-group invisible">
                  <input type="hidden" class="form-control" id="letter-data" readonly>
              </div>
              <div class="form-group">
                <label>Nomor Surat</label>
                <input type="text" class="form-control" placeholder="Nomor Surat Permohonan" name="letter_number" id="letter_number">
              </div>
              <div class="modal-footer align-right mt-2 pt-2">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-chevron-left mr-1"></i> Batal</a>
                <button type="submit" class="btn btn-primary" onclick="finalizationLetter()"><i class="fa fa-save fa-sm mr-1"></i> Selesaikan</button>
              </div>
          </form>
        </div>
    </div>
  </div>

  <div class="modal fade" id="modal-response">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Upload Surat Balasan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" id="form-response" method="POST" class="px-3">
                @csrf
                {{ method_field('put') }}

                <div class="form-group invisible">
                    <input type="hidden" class="form-control" id="letter-id" readonly>
                </div>
                <div class="form-group">
                  <label>Scan Surat Balasan</label>
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="reponse-letter">
                    <label class="custom-file-label" for="customFile">Pilih File</label>
                  </div>
                </div>
                <div class="modal-footer align-right mt-2 pt-2">
                  <button type="button" class="btn btn-default" data-dismiss="modal">
                    <i class="fa fa-chevron-left mr-1"></i> Batal
                  </a>
                  <button type="submit" class="btn btn-primary" onclick="responseLetter()">
                    <i class="fa fa-save fa-sm mr-1"></i> Simpan
                  </button>
                </div>
            </form>
        </div>
    </div>
  </div>

  <script>
    function setDataToFinalModal(data){
        $('#letter-data').val(data);
    }

    function finalizationLetter(){
      var letterdata = $('#letter-data').val();
      if(window.location.href.includes('public')){
        $('#form-complete').attr('action', '/public/finalization-letter/' + letterdata);
      }else{
        $('#form-complete').attr('action', '/finalization-letter/' + letterdata);
      }

      $('#form-complete').unbind("submit");
      $('#form-complete').submit();
    }

    function acceptLetter(){
      var letterdata = $('#letter-data').val();
      if(window.location.href.includes('public')){
        $('#form-accept').attr('action', '/public/accept-letter/' + letterdata);
      }else{
        $('#form-accept').attr('action', '/accept-letter/' + letterdata);
      }

      $('#form-accept').unbind("submit");
      $('#form-accept').submit();
    }
  </script>
@endsection