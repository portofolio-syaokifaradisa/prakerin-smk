@extends('layout.app')

@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title mt-2">Data Wilayah Instansi</h3>
    </div>
    <div class="card-body">
      <table class="table table-bordered table-striped" id="report-region-datatables">
        <thead>
        <tr>
            <th>Wilayah </th>
            <th>Kota</th>
        </tr>
        </thead>
        <tbody>
          
        </tbody>
        <tfoot>
            <th id="name">Wilayah </th>
            <th id="city">Kota</th>
        </tfoot>
      </table>
    </div>
  </div>

  <script type="text/javascript">
    $(function () {
        $('#report-region-datatables tfoot th').each(function () {
            var name = $(this).attr('id');
            var title = $(this).text();
            $(this).html('<input type="text" name="'+ name +'" placeholder="Filter ' + title + '" id="'+ name +'-form"/>');
        });

        $('#report-region-datatables').DataTable({
            processing: true,
            serverSide: true,
            dom: 'Brtip',
            ajax: "{{ route('report.region.index') }}",
            columns: [
                {data: 'name', name: 'name'},
                {data: 'city', name: 'city'},
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
                        var name = $('#name-form').val();
                        var city = $('#city-form').val();

                        if(window.location.href.includes('public')){
                        
                            location.href = `http://prakerinsmk.test/public/report/region/download?name=${name}&city=${city}`
                        }else{
                            location.href = `http://prakerinsmk.test/report/region/download?name=${name}&city=${city}`

                        }
                    }
                }
                // 'pdf', 'excel', 'csv'
            ],
        });
    });
  </script>
@endsection