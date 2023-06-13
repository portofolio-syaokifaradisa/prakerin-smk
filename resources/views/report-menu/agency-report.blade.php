@extends('layout.app')

@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title mt-2">Data Industri</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="report-agency-datatables">
                <thead>
                <tr>
                    <th>Wilayah</th>
                    <th>Instansi</th>
                    <th>Pimpinan</th>
                    <th>NIP</th>
                    <th>Telepon</th>
                    <th>Alamat</th>
                    <th>Karakteristik</th>
                </tr>
                </thead>
                <tbody>
                  
                </tbody>
                <tfoot>
                    <th id="region">Wilayah</th>
                    <th id="name">Instansi</th>
                    <th id="leader">Pimpinan</th>
                    <th id="nip">NIP</th>
                    <th id="phone">Telepon</th>
                    <th id="address">Alamat</th>
                    <th id="characteristic">Karakteristik</th>
                </tfoot>
            </table>
        </div>
    </div>
  </div>

  <script type="text/javascript">
    $(function () {
        $('#report-agency-datatables tfoot th').each(function () {
            var name = $(this).attr('id');
            var title = $(this).text();
            $(this).html('<input type="text" name="'+ name +'" placeholder="Filter ' + title + '" id="'+ name +'-form"/>');
        });

        $('#report-agency-datatables').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: true,
            dom: 'Brtip',
            ajax: "{{ route('report.agency.index') }}",
            columns: [
                {data: 'region', name: 'region'},
                {data: 'name', name: 'name'},
                {data: 'leader', name: 'leader'},
                {data: 'nip', name: 'nip'},
                {data: 'phone', name: 'phone'},
                {data: 'address', name: 'address'},
                {data: 'characteristic', name: 'characteristic'},
            ],
            initComplete: function () {
                this.api().columns().every(function () {
                    var that = this;
 
                    $('input', this.footer()).on('keyup change clear', function () {
                        if (that.search() !== this.value) {
                            that.search(this.value).draw();
                        }
                    });
                });
            },
            buttons: [
                {
                    text: 'Cetak Laporan',
                    action: async function ( e, dt, node, config ) {
                        var region = $('#region-form').val();
                        var name = $('#name-form').val();
                        var leader = $('#leader-form').val();
                        var nip = $('#nip-form').val();
                        var phone = $('#phone-form').val();
                        var address = $('#address-form').val();
                        var characteristic = $('#characteristic-form').val();

                        if(window.location.href.includes('public')){
                            location.href = `http://prakerinsmk.test/public/report/agency/download?region=${region}&name=${name}&leader=${leader}&nip=${nip}&phone=${phone}&address=${address}&characteristic=${characteristic}`
                        }else{
                            location.href = `http://prakerinsmk.test/report/agency/download?region=${region}&name=${name}&leader=${leader}&nip=${nip}&phone=${phone}&address=${address}&characteristic=${characteristic}`
                        }
                    }
                }
                // 'pdf', 'excel', 'csv'
            ],
        });
    });
  </script>
@endsection