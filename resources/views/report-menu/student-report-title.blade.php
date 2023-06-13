@extends('layout.app')

@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title mt-2">Data Judul Laporan</h3>
    </div>
    <div class="card-body">
      <table class="table table-bordered table-striped" id="report-title-datatables">
        <thead>
        <tr>
            <th>Judul</th>
            <th>Nama Siswa</th>
            <th>NISN</th>
            <th>Jurusan</th>
        </tr>
        </thead>
        <tbody>
            
        </tbody>
        <tfoot>
            <th id="title">Judul</th>
            <th id="student">Nama Siswa</th>
            <th id="nisn">NISN</th>
            <th id="department">Jurusan</th>
        </tfoot>
      </table>
    </div>
  </div>

  <script type="text/javascript">
    $(function () {
        $('#report-title-datatables tfoot th').each(function () {
            var name = $(this).attr('id');
            var title = $(this).text();
            $(this).html('<input type="text" name="'+ name +'" placeholder="Filter ' + title + '" id="'+ name +'-form"/>');
        });

        $('#report-title-datatables').DataTable({
            processing: true,
            serverSide: true,
            dom: 'Brtip',
            ajax: "{{ route('report.student-report-title.index') }}",
            columns: [
                {data: 'title', name: 'title'},
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
                        var title = $('#title-form').val();
                        var student = $('#student-form').val();
                        var nisn = $('#nisn-form').val();
                        var department = $('#department-form').val();

                        if(window.location.href.includes('public')){
                        
                            location.href = `http://prakerinsmk.test/public/report/student-report-title/download?title=${title}&student=${student}&nisn=${nisn}&department=${department}`
                        }else{
                            location.href = `http://prakerinsmk.test/report/student-report-title/download?title=${title}&student=${student}&nisn=${nisn}&department=${department}`

                        }
                    }
                }
                // 'pdf', 'excel', 'csv'
            ],
        });
    });
  </script>
@endsection