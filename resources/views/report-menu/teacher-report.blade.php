@extends('layout.app')

@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title mt-2">Data Guru</h3>
    </div>
    <div class="card-body">
      <table class="table table-bordered table-striped" id="report-teacher-datatables">
        <thead>
        <tr>
          <th>Nama lengkap</th>
          <th>NIP</th>
          <th>Jabatan</th>
          <th>Email</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
        <tfoot>
            <th id="name">Nama lengkap</th>
            <th id="nip">NIP</th>
            <th id="position">Jabatan</th>
            <th id="email">Email</th>
        </tfoot>
      </table>
    </div>
  </div>

  <script type="text/javascript">
    $(function () {
        $('#report-teacher-datatables tfoot th').each(function () {
            var name = $(this).attr('id');
            var title = $(this).text();
            $(this).html('<input type="text" name="'+ name +'" placeholder="Filter ' + title + '" id="'+ name +'-form"/>');
        });

        $('#report-teacher-datatables').DataTable({
            processing: true,
            serverSide: true,
            dom: 'Brtip',
            ajax: "{{ route('report.teacher.index') }}",
            columns: [
                {data: 'name', name: 'name'},
                {data: 'nip', name: 'nip'},
                {data: 'position', name: 'position'},
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
                    text: 'Cetak Laporan Guru',
                    action: async function ( e, dt, node, config ) {
                        var name = $('#name-form').val();
                        var nip = $('#nip-form').val();
                        var position = $('#position-form').val();

                        if(window.location.href.includes('public')){
                            location.href = `http://prakerinsmk.test/public/report/teacher/download?name=${name}&nip=${nip}&position=${position}`
                        
                        }else{
                            location.href = `http://prakerinsmk.test/report/teacher/download?name=${name}&nip=${nip}&position=${position}`

                        }
                    }
                },
                {
                    text: 'Cetak Laporan Akun',
                    action: async function ( e, dt, node, config ) {
                        var name = $('#name-form').val();
                        var nip = $('#nip-form').val();
                        var position = $('#position-form').val();
                        var email = $('#email-form').val();

                        if(window.location.href.includes('public')){
                            location.href = `http://prakerinsmk.test/public/report/teacher/download-account?name=${name}&nip=${nip}&position=${position}&email=${email}`
                        
                        }else{
                            location.href = `http://prakerinsmk.test/report/teacher/download-account?name=${name}&nip=${nip}&position=${position}&email=${email}`

                        }
                    }
                }
                // 'pdf', 'excel', 'csv'
            ],
        });
    });
  </script>
@endsection