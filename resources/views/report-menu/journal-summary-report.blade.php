@extends('layout.app')

@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title mt-2">Data Jurnal Siswa</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="report-journal-datatables">
                <thead>
                <tr>
                    <th class="text-center">Aksi</th>
                    <th class="text-center">NISN</th>
                    <th class="text-center">Siswa</th>
                    <th class="text-center">Jurusan</th>
                    <th class="text-center">Pencapaian Kompetensi Dasar</th>
                </tr>
                </thead>
                <tbody>
                  
                </tbody>
                <tfoot>
                    <th class="text-center" id="action">Aksi</th>
                    <th class="text-center" id="nisn">NISN</th>
                    <th class="text-center" id="student">Siswa</th>
                    <th class="text-center" id="department">Jurusan</th>
                    <th class="text-center" id="competence">Pencapaian Kompetensi Dasar</th>
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
            if(name != "competence"){
                $(this).html('<input type="text" name="'+ name +'" placeholder="Filter ' + title + '" id="'+ name +'-form"/>');
            }else{
                $(this).html(`
                    <select class="custom-select" name="${name}-form" id="${name}-form">
                        <option value="" selected hidden>Filter Capaian</option>
                        <option value="">Semua</option>
                        <option value="Tercapai">Tercapai</option>
                        <option value="Tidak Mencapai">Tidak Mencapai</option>
                    </select>
                `);
            }
        });

        $('#report-journal-datatables').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: true,
            dom: 'Brtip',
            ajax: "{{ route('report.journal-summary.index') }}",
            columns: [
                {data: 'action', name: 'action'},
                {data: 'nisn', name: 'nisn'},
                {data: 'student', name: 'student'},
                {data: 'department', name: 'department'},
                {data: 'competence', name: 'competence'},
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
                        var nisn = $('#nisn-form').val();
                        var student = $('#student-form').val();
                        var department = $('#department-form').val();
                        var competence = $('#competence-form').val();
                        if(window.location.href.includes('public')){
                        
                            location.href = `http://prakerinsmk.test/public/report/journal-summary/download?nisn=${nisn}&student=${student}&department=${department}&competence=${competence}`
                        }else{
                            location.href = `http://prakerinsmk.test/report/journal-summary/download?nisn=${nisn}&student=${student}&department=${department}&competence=${competence}`

                        }
                    }
                }
                // 'pdf', 'excel', 'csv'
            ],
        });
    });
  </script>
@endsection