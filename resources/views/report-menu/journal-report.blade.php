@extends('layout.app')

@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title mt-2">
        Jurnal Magang Siswa {{ $student->name }} 
        Jurusan {{ $student->grade_class->Department->name }} 
        di {{ $student->Journal[0]->application_letter->Agency->name }}
        Wilayah {{ $student->Journal[0]->application_letter->Agency->Region->name }}
    </h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="report-journal-datatables">
                <thead>
                <tr>
                    <th class="text-center">Tanggal</th>
                    <th class="text-center">Kegiatan</th>
                </tr>
                </thead>
                <tbody>
                  
                </tbody>
                <tfoot>
                    <th class="text-center" id="date">Tanggal</th>
                    <th class="text-center" id="activity">Kegiatan</th>
                </tfoot>
            </table>
        </div>
    </div>
  </div>

  <script type="text/javascript">
    $(function () {
        $('#report-journal-datatables tfoot th').each(function () {
            var name = $(this).attr('id');
            var title = $(this).text();
            $(this).html('<input type="text" name="'+ name +'" placeholder="Filter ' + title + '" id="'+ name +'-form"/>');
        });

        $('#report-journal-datatables').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: true,
            dom: 'Brtip',
            ajax: "{{ route('report.journal.index', ['id' => $student->id]) }}",
            columns: [
                {data: 'date', name: 'date'},
                {data: 'activity', name: 'activity'},
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
                        var activity = $('#activity-form').val();
                        var student_id = {{ $student->id }};
                        if(window.location.href.includes('public')){
                            location.href = `http://prakerinsmk.test/public/report/journal/${student_id}/download?date=${date}&activity=${activity}`
                        
                        }else{
                            location.href = `http://prakerinsmk.test/report/journal/${student_id}/download?date=${date}&activity=${activity}`

                        }
                    }
                }
                // 'pdf', 'excel', 'csv'
            ],
        });
    });
  </script>
@endsection