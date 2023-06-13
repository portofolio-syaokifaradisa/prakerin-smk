@extends('layout.app')

@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title mt-2">Data Pembimbing Siswa Magang</h3>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered table-striped" id="report-mentoring-datatables">
            <thead>
            <tr>
              <th>Wilayah</th>
              <th>Guru</th>
              <th>NIP</th>
              <th>Siswa</th>
              <th>NISN</th>
              <th>Jurusan</th>
            </tr>
            </thead>
            <tbody>
    
            </tbody>
            <tfoot>
                <th id="region">Wilayah</th>
                <th id="teacher">Guru</th>
                <th id="nip">NIP</th>
                <th id="student">Siswa</th>
                <th id="nisn">NISN</th>
                <th id="department">Jurusan</th>
            </tfoot>
          </table>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    $(function () {
        $('#report-mentoring-datatables tfoot th').each(function () {
            var name = $(this).attr('id');
            var title = $(this).text();
            $(this).html('<input type="text" name="'+ name +'" placeholder="Filter ' + title + '" id="'+ name +'-form"/>');
        });

        $('#report-mentoring-datatables').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: true,
            dom: 'Brtip',
            ajax: "{{ route('report.mentoring.index') }}",
            columns: [
                {data: 'region', name: 'region'},
                {data: 'teacher', name: 'teacher'},
                {data: 'nip', name: 'nip'},
                {data: 'student', name: 'student'},
                {data: 'nisn', name: 'nisn'},
                {data: 'department', name: 'department'},
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
                        var teacher = $('#teacher-form').val();
                        var nip = $('#nip-form').val();
                        var student = $('#student-form').val();
                        var nisn = $('#nisn-form').val();
                        var department = $('#department-form').val();

                        if(window.location.href.includes('public')){
                            location.href = `http://prakerinsmk.test/public/report/mentoring/download?region=${region}&teacher=${teacher}&nip=${nip}&student=${student}&nisn=${nisn}&department=${department}`
                        
                        }else{
                            location.href = `http://prakerinsmk.test/report/mentoring/download?region=${region}&teacher=${teacher}&nip=${nip}&student=${student}&nisn=${nisn}&department=${department}`

                        }
                    }
                }
                // 'pdf', 'excel', 'csv'
            ],
        });
    });
  </script>
@endsection