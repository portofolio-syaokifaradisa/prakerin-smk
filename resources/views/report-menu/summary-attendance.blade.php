@extends('layout.app')

@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title mt-2">Data Absensi</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="report-attendance-datatables">
                <thead>
                <tr>
                    <th class="text-center">Aksi</th>
                    <th class="text-center">NISN</th>
                    <th class="text-center">Nama Siswa</th>
                    <th class="text-center">Jurusan</th>
                    <th class="text-center">Hadir</th>
                    <th class="text-center">Izin</th>
                    <th class="text-center">Sakit</th>
                    <th class="text-center">Alpha</th>
                </tr>
                </thead>
                <tbody>
                  
                </tbody>
                <tfoot>
                    <th class="text-center" id="action">Aksi</th>
                    <th class="text-center" id="nisn">NISN</th>
                    <th class="text-center" id="student">Nama Siswa</th>
                    <th class="text-center" id="department">Jurusan</th>
                    <th class="text-center" id="present">Hadir</th>
                    <th class="text-center" id="permit">Izin</th>
                    <th class="text-center" id="sick">Sakit</th>
                    <th class="text-center" id="alpha">Alpha</th>
                </tfoot>
            </table>
        </div>
    </div>
  </div>

  <script type="text/javascript">
    $(function () {
        $('#report-attendance-datatables tfoot th').each(function () {
            var name = $(this).attr('id');
            var title = $(this).text();
            if(name != "action"){
                $(this).html('<input type="text" name="'+ name +'" placeholder="Filter ' + title + '" id="'+ name +'-form"/>');
            }else{
                $(this).html('');
            }
        });

        $('#report-attendance-datatables').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: true,
            dom: 'Brtip',
            ajax: "{{ route('report.attendance-summary.index') }}",
            columns: [
                {data: 'action', name: 'action'},
                {data: 'nisn', name: 'nisn'},
                {data: 'student', name: 'student'},
                {data: 'department', name: 'department'},
                {data: 'present', name: 'present'},
                {data: 'permit', name: 'permit'},
                {data: 'sick', name: 'sick'},
                {data: 'alpha', name: 'alpha'},
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
                        var student = $('#student-form').val();
                        var department = $('#department-form').val();
                        var present = $('#present-form').val();
                        var permit = $('#permit-form').val();
                        var sick = $('#sick-form').val();
                        var alpha = $('#alpha-form').val();
                        var nisn = $('#nisn-form').val();
                        if(window.location.href.includes('public')){
                            location.href = `http://prakerinsmk.test/public/report/attendance-summary/download?student=${student}&department=${department}&present=${present}&permit=${permit}&sick=${sick}&alpha=${alpha}&nisn=${nisn}`
                        
                        }else{
                            location.href = `http://prakerinsmk.test/report/attendance-summary/download?student=${student}&department=${department}&present=${present}&permit=${permit}&sick=${sick}&alpha=${alpha}&nisn=${nisn}`

                        }
                    }
                }
                // 'pdf', 'excel', 'csv'
            ],
        });
    });
  </script>
@endsection