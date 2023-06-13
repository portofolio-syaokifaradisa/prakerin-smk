@extends('layout.app')

@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title mt-2">Data Surat Permohonan</h3>
      <a href="{{ route('app-letter-create') }}" class="btn btn-sm btn-primary float-right px-3"><i class="fas fa-plus mr-2"></i>Ajukan Surat</a>
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
          <th>Nomor Surat</th>
          <th>Instansi</th>
          <th>Pimpinan</th>
          <th>Wilayah</th>
          <th style="width: 5%">Status</th>
          <th style="width: 10%">Aksi</th>
        </tr>
        </thead>
        <tbody>
          @for ($i = 0; $i < count($letter); $i++)
            <tr>
              <td class="align-middle">{{ $i + 1 }}</td>
              <td class="align-middle">{{ $letter[$i]->letter_number }}</td>
              <td class="align-middle">{{ $letter[$i]->Agency->name }}</td>
              <td class="align-middle">{{ $letter[$i]->Agency->leader }}</td>
              <td class="align-middle">{{ $letter[$i]->Agency->Region->name }}</td>
              <td class="text-center align-middle">
                @if ($letter[$i]->status == "DELIVERED")
                  <span class="badge bg-primary">Terkirim</span>
                @elseif ($letter[$i]->status == "PENDING")
                  <span class="badge bg-warning">Diproses</span>
                @else
                  <span class="badge bg-success">Selesai</span>
                @endif
              </td>
              <td class="text-center align-middle">
                @if ($letter[$i]->status == "DELIVERED")
                  <a href="" class="badge bg-secondary" onclick="showEditModal({{ $letter[$i]->id }})" data-toggle="modal" data-target="#modal-edit">Ubah</a>
                  <a href="#" class="badge bg-danger" onclick="deleteItem('{{ route('app-letter-delete', ['id' => $letter[$i]->id]) }}')">Hapus</a>
                @elseif ($letter[$i]->status == "COMPLETE")
                  <?php $letter_number_file_name = str_replace('/','_', $letter[$i]->letter_number); ?>
                  @if (File::exists(public_path('uploads/response_letter/'.$letter_number_file_name.'.pdf')))
                    <a href="public/download-response-letter/{{ $letter_number_file_name }}" class="badge bg-success px-2 py-1"><i class="fas fa-print mr-1"></i> Surat Balasan</a>
                    <a href="{{ route('app-letter.journal.index', ['id' => $letter[$i]->id]) }}" class="badge bg-secondary px-2 py-1">
                      <i class="fas fa-book mr-1"></i>
                      Jurnal Kegiatan
                    </a>
                  @else
                    <a href="" class="badge bg-secondary" onclick="setLetteridOnModal({{ $letter[$i]->id }})" data-toggle="modal" data-target="#modal-response">Surat Balasan</a>
                  @endif
                @endif
            </tr>
          @endfor
        </tbody>
      </table>
    </div>
  </div>



  {{-- Modal Edit --}}
  <div class="modal fade" id="modal-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ubah Data Surat</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" id="form-edit" method="POST" class="px-3">
                @csrf
                {{ method_field('put') }}

                <div class="form-group invisible">
                    <input type="hidden" class="form-control letter-id" readonly>
                </div>
                <div class="form-group">
                  <label>Instansi</label>
                  <select class="custom-select" name="agency_id" id="agency_form">
                  </select>
                </div>
                <div class="modal-footer align-right mt-2 pt-2">
                  <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-chevron-left mr-1"></i> Batal</a>
                  <button type="submit" class="btn btn-primary" onclick="editLetter()"><i class="fa fa-save fa-sm mr-1"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
  </div>

  {{-- Modal Terima Surat --}}
  <div class="modal fade" id="modal-accept" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Konfirmasi Penerimaan Pengajuan Surat</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Yakin ingin menerima pengajuan surat?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"> Batal</button>
                <a class="btn btn-sm btn-success btn-ok text-white px-3"><i class="fa-solid fa-circle-check"></i> Ya</a>
            </div>
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
                  <input type="hidden" class="form-control letter-id" readonly>
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
            <form action="#" id="form-response" method="POST" class="px-3" enctype='multipart/form-data'>
                @csrf
                {{ method_field('put') }}

                <div class="form-group invisible">
                    <input type="hidden" class="form-control letter-id" readonly>
                </div>
                <div class="form-group">
                  <label>Scan Surat Balasan</label>
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="reponse-letter" name="file">
                    <label class="custom-file-label" for="customFile">Pilih File</label>
                  </div>
                </div>
                <div class="modal-footer align-right mt-2 pt-2">
                  <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-chevron-left mr-1"></i> Batal</a>
                  <button type="submit" class="btn btn-primary" onclick="responseLetter()"><i class="fa fa-save fa-sm mr-1"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
  </div>

  <script>
    $(function () {
      $('#modal-accept').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
      });
    });
    
    function showEditModal(letterId){
      populateAgencyDropdown(letterId);
      changeDisableStatusForm(false);
    }

    function showDetailModal(letterId){
      changeDisableStatusForm(true);
      getLetterById(letterId);
    }

    function setLetteridOnModal(id){
      $('.letter-id').val(id);
    }

    function finalizationLetter(){
      var letterId = $('.letter-id').val();
      if(window.location.href.includes('public')){
        $('#form-complete').attr('action', '/public/finalization-letter/' + letterId);
      }else{
        $('#form-complete').attr('action', '/finalization-letter/' + letterId);
      }

      $('#form-complete').unbind("submit");
      $('#form-complete').submit();
    }

    function editLetter(){
      var letter_id = $('.letter-id').val();
      if(window.location.href.includes('public')){
        $('#form-edit').attr('action', '/public/app-letter/' + letter_id);
      }else{
        $('#form-edit').attr('action', '/app-letter/' + letter_id);
      }

      $('#form-edit').unbind("submit");
      $('#form-edit').submit();
    }

    function responseLetter(){
      var letter_id = $('.letter-id').val();
      $('#form-response').attr('action', '/public/response-letter/' + letter_id);
      if(window.location.href.includes('public')){
      }else{
        $('#form-response').attr('action', '/response-letter/' + letter_id);
      }

      $('#form-response').unbind("submit");
      $('#form-response').submit();
    }

    function populateAgencyDropdown(letterId){
      $.ajax({
        url : window.location.href.includes('public') ? "/public/agency-all" : "/agency-all",
        type : "GET",
        success: function(agency){
          $.ajax({
            url : window.location.href.includes('public') ? "/app-letter/" + letterId : "/public/app-letter/" + letterId,
            type : "GET",
            success: function(letter){
              var agenciesData = JSON.parse(agency);
              var letterData = JSON.parse(letter);

              $('#letter-id').val(letterData.id);

              var options = [];
              for (var i = 0; i < agenciesData.length; i++) {
                if(letterData.agency_id == agenciesData[i].id){
                  options.push('<option value="' + agenciesData[i].id + '" selected>' + agenciesData[i].name + ' - ' + agenciesData[i].region.name + '</option>');
                }else{
                  options.push('<option value="' + agenciesData[i].id + '">' + agenciesData[i].name + ' - ' + agenciesData[i].region.name + '</option>');
                }
              }

              $("#agency_form").html(options.join(''));
            }
          });
        }
      });
    }

    function changeDisableStatusForm(status){
      $('#agency').attr('disabled', status);
      $('#leader').attr('disabled', status);
      $('#address').attr('disabled', status);
      $('#nip').attr('disabled', status);
      $('#region').attr('disabled', status);
      $('#phone').attr('disabled', status);

      if(status){
        $('.modal-footer').hide();
        $('.modal-title').text("Detail Data Pengajuan");
      }else{
        $('.modal-footer').show();
        $('.modal-title').text("Ubah Data Pengajuan");
      }
    }
  </script>
@endsection