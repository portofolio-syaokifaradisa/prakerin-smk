@extends('layout.app')

@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title mt-2">Data Bimbingan Siswa Magang</h3>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered table-striped" id="report-monitoring-datatables">
            <thead>
            <tr>
                <th>Tanggal</th>
                <th>Guru</th>
                <th>Wilayah</th>
                <th>Industri</th>
                <th>Bimbingan</th>
            </tr>
            </thead>
            <tbody>
    
            </tbody>
            <tfoot>
                <th id="date">Tanggal</th>
                <th id="teacher">Guru</th>
                <th id="region">Wilayah</th>
                <th id="agency">Industri</th>
                <th id="description">Bimbingan</th>
            </tfoot>
          </table>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    $(function () {
        $('#report-monitoring-datatables tfoot th').each(function () {
            var name = $(this).attr('id');
            var title = $(this).text();

            $(this).html('<input type="text" name="'+ name +'" placeholder="Filter ' + title + '" id="'+ name +'-form"/>');
        });

        $('#report-monitoring-datatables').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: true,
            dom: 'Brtip',
            ajax: "{{ route('report.monitoring.index') }}",
            columns: [
                {data: 'date', name: 'date'},
                {data: 'teacher', name: 'teacher'},
                {data: 'region', name: 'region'},
                {data: 'agency', name: 'agency'},
                {data: 'description', name: 'description'},
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
                        var date = $('#date-form').val();
                        var teacher = $('#teacher-form').val();
                        var region = $('#region-form').val();
                        var agency = $('#agency-form').val();
                        var description = $('#description-form').val();
                        if(window.location.href.includes('public')){
                            location.href = `http://prakerinsmk.test/public/report/monitoring/download?date=${date}&teacher=${teacher}&region=${region}&agency=${agency}&description=${description}`
                        
                        }else{
                            location.href = `http://prakerinsmk.test/report/monitoring/download?date=${date}&teacher=${teacher}&region=${region}&agency=${agency}&description=${description}`

                        }
                    }
                }
                // 'pdf', 'excel', 'csv'
            ],
        });
    });
  </script>
@endsection