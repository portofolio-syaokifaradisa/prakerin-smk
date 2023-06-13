@extends('layout.app')

@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title mt-2">Data Absensi {{ $student->name }}</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="report-attendance-datatables">
                <thead>
                <tr>
                    <th class="text-center">Tanggal</th>
                    <th class="text-center">Datang</th>
                    <th class="text-center">Pulang</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Keterangan</th>
                </tr>
                </thead>
                <tbody>
                  
                </tbody>
                <tfoot>
                    <th class="text-center" id="date">Tanggal</th>
                    <th class="text-center" id="in">Datang</th>
                    <th class="text-center" id="out">Pulang</th>
                    <th class="text-center" id="status">Status</th>
                    <th class="text-center" id="description">Keterangan</th>
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
            if(name === "status"){
                $(this).html(`
                    <select class="custom-select" name="${name}-form" id="${name}-form">
                        <option value="" selected hidden>Filter Status</option>
                        <option value="">Semua</option>
                        <option value="hadir">Hadir</option>
                        <option value="alpha">Alpha</option>
                        <option value="izin">Izin</option>
                        <option value="sakit">Sakit</option>
                    </select>
                `);
            }else{
                $(this).html('<input type="text" name="'+ name +'" placeholder="Filter ' + title + '" id="'+ name +'-form"/>');
            }
        });

        $('#report-attendance-datatables').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: true,
            dom: 'Brtip',
            ajax: "{{ route('report.attendance.index', ['id' => $student->id]) }}",
            columns: [
                {data: 'date', name: 'date'},
                {data: 'in', name: 'in'},
                {data: 'out', name: 'out'},
                {data: 'status', name: 'status'},
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

                    $('select', this.footer()).on('change', function () {
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
                        var studentId = {{ $student->id }};
                        var date = $('#date-form').val();
                        var timeIn = $('#in-form').val();
                        var timeOut = $('#out-form').val();
                        var status = $('#status-form').val();
                        var description = $('#description-form').val();

                        if(window.location.href.includes('public')){
                            location.href = `http://prakerinsmk.test/public/report/attendance/${studentId}/download?date=${date}&in=${timeIn}&out=${timeOut}&status=${status}&description=${description}`
                        }else{
                            location.href = `http://prakerinsmk.test/report/attendance/${studentId}/download?date=${date}&in=${timeIn}&out=${timeOut}&status=${status}&description=${description}`
                        }
                    }
                }
                // 'pdf', 'excel', 'csv'
            ],
        });
    });
  </script>
@endsection