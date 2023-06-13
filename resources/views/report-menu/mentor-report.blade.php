@extends('layout.app')

@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title mt-2">Data Guru Pembimbing</h3>
    </div>
    <div class="card-body">
      <table class="table table-bordered table-striped" id="report-mentor-datatables">
        <thead>
        <tr>
          <th>NIP</th>
          <th>Nama Guru</th>
          <th>Jurusan</th>
          <th>Email</th>
          <th>Wilayah</th>
          <th>Kota</th>
        </tr>
        </thead>
        <tbody>
          
        </tbody>
        <tfoot>
            <th id="nip">NIP</th>
            <th id="name">Nama Guru</th>
            <th id="department">Jurusan</th>
            <th id="email">Email</th>
            <th id="region">Wilayah</th>
            <th id="city">Kota</th>
        </tfoot>
      </table>
    </div>
  </div>

  <script type="text/javascript">
    $(function () {
        $('#report-mentor-datatables tfoot th').each(function () {
            var name = $(this).attr('id');
            var title = $(this).text();
            $(this).html('<input type="text" name="'+ name +'" placeholder="Filter ' + title + '" id="'+ name +'-form"/>');
        });

        $('#report-mentor-datatables').DataTable({
            processing: true,
            serverSide: true,
            dom: 'Brtip',
            ajax: "{{ route('report.mentor.index') }}",
            columns: [
                {data: 'nip', name: 'nip'},
                {data: 'name', name: 'name'},
                {data: 'department', name: 'department'},
                {data: 'email', name: 'email'},
                {data: 'region', name: 'region'},
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
                        var nip = $('#nip-form').val();
                        var name = $('#name-form').val();
                        var department = $('#department-form').val();
                        var region = $('#region-form').val();
                        var city = $('#city-form').val();
                        var email = $('#email-form').val();
                        if(window.location.href.includes('public')){
                        
                            location.href = `http://prakerinsmk.test/public/report/mentor/download?name=${name}&nip=${nip}&region=${region}&city=${city}&email=${email}&department=${department}`
                        }else{
                            location.href = `http://prakerinsmk.test/report/mentor/download?name=${name}&nip=${nip}&region=${region}&city=${city}&email=${email}&department=${department}`

                        }
                    }
                }
                // 'pdf', 'excel', 'csv'
            ],
        });
    });
  </script>
@endsection