@extends('layout.app')

@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title mt-2">Laporan Data Siswa</h3>
    </div>
    <div class="card-body">
      <table class="table table-bordered table-striped" id="report-student-datatables">
        <thead>
            <tr>
                <th>Nama Siswa</th>
                <th>NISN</th>
                <th>Kelas</th>
                <th>Jurusan</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
        <tfoot>
            <tr>
                <th id="name">Nama Siswa</th>
                <th id="nisn">NISN</th>
                <th id="grade">Kelas</th>
                <th id="department">Jurusan</th>
                <th id="email">Email</th>
            </tr>
        </tfoot>
      </table>
    </div>
  </div>

  <script type="text/javascript">
    $(function () {
        $('#report-student-datatables tfoot th').each(function () {
            var name = $(this).attr('id');
            var title = $(this).text();
            $(this).html('<input type="text" name="'+ name +'" placeholder="Filter ' + title + '" id="'+ name +'-form"/>');
        });

        $('#report-student-datatables').DataTable({
            processing: true,
            serverSide: true,
            dom: 'Brtip',
            ajax: "{{ route('report.student.index') }}",
            columns: [
                {data: 'name', name: 'name'},
                {data: 'nisn', name: 'nisn'},
                {data: 'grade', name: 'grade'},
                {data: 'department', name: 'department'},
                {data: 'email', name: 'email'},
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
                    text: 'Cetak Laporan Siswa',
                    action: async function ( e, dt, node, config ) {
                        var name = $('#name-form').val();
                        var nisn = $('#nisn-form').val();
                        var grade = $('#grade-form').val();
                        var department = $('#department-form').val();
                        if(window.location.href.includes('public')){
                            location.href = `http://prakerinsmk.test/public/report/student/download?name=${name}&nisn=${nisn}&grade=${grade}&department=${department}`
                        
                        }else{
                            location.href = `http://prakerinsmk.test/report/student/download?name=${name}&nisn=${nisn}&grade=${grade}&department=${department}`

                        }
                    }
                },{
                    text: 'Cetak Laporan Akun',
                    action: async function ( e, dt, node, config ) {
                        var name = $('#name-form').val();
                        var nisn = $('#nisn-form').val();
                        var grade = $('#grade-form').val();
                        var department = $('#department-form').val();
                        var email = $('#email-form').val();

                        if(window.location.href.includes('public')){
                            location.href = `http://prakerinsmk.test/public/report/student/download-account?name=${name}&nisn=${nisn}&grade=${grade}&department=${department}&email=${email}`
                        
                        }else{

                            location.href = `http://prakerinsmk.test/report/student/download-account?name=${name}&nisn=${nisn}&grade=${grade}&department=${department}&email=${email}`
                        }
                    }
                }
                // 'pdf', 'excel', 'csv'
            ],
        });
    });
  </script>
@endsection