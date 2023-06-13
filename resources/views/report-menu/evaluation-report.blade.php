@extends('layout.app')

@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title mt-2">Data Penilaian</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="report-evaluation-datatables">
                <thead>
                <tr>
                    <th>NISN</th>
                    <th>Siswa</th>
                    <th>Jurusan</th>
                    <th class="text-center">Pengetahuan<br>Teori</th>
                    <th class="text-center">Keterampilan<br>Dasar</th>
                    <th class="text-center">Keselamatan<br>Kerja</th>
                    <th class="text-center">Disiplin<br>Kerja</th>
                    <th class="text-center">Sikap dan<br>Tanggungjawab</th>
                    <th class="text-center">Nilai<br>Akhir</th>
                    <th class="text-center">Predikat<br>Nilai</th>
                </tr>
                </thead>
                <tbody>
                  
                </tbody>
                <tfoot>
                    <th id="nisn">NISN</th>
                    <th id="student">Siswa</th>
                    <th id="department">Jurusan</th>
                    <th id="teori">Pengetahuan Teori</th>
                    <th id="keterampilan">Keterampilan Dasar</th>
                    <th id="keselamatan">Keselamatan Kerja</th>
                    <th id="disiplin">Disiplin Kerja</th>
                    <th id="sikap">Sikap dan Tanggungjawab</th>
                    <th id="score">Nilai Akhir</th>
                    <th id="predicate">Predikat Nilai</th>
                </tfoot>
            </table>
        </div>
    </div>
  </div>

  <script type="text/javascript">
    $(function () {
        $('#report-evaluation-datatables tfoot th').each(function () {
            var name = $(this).attr('id');
            var title = $(this).text();
            if(name != "predicate"){
                $(this).html('<input type="text" name="'+ name +'" placeholder="Filter ' + title + '" id="'+ name +'-form"/>');
            }else{
                $(this).html(`
                    <select class="custom-select" name="${name}-form" id="${name}-form">
                        <option value="" selected hidden>Filter Predikat</option>
                        <option value="">Semua</option>
                        <option value="A (Sangat Baik)">A (Sangat Baik)</option>
                        <option value="B (Baik)">B (Baik)</option>
                        <option value="C (Cukup)">C (Cukup)</option>
                        <option value="D (Kurang)">D (Kurang)</option>
                    </select>
                `);
            }
        });

        $('#report-evaluation-datatables').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: true,
            dom: 'Brtip',
            ajax: "{{ route('report.evaluation.index') }}",
            columns: [
                {data: 'nisn', name: 'nisn'},
                {data: 'student', name: 'student'},
                {data: 'department', name: 'department'},
                {data: 'teori', name: 'teori'},
                {data: 'keterampilan', name: 'keterampilan'},
                {data: 'keselamatan', name: 'keselamatan'},
                {data: 'disiplin', name: 'disiplin'},
                {data: 'sikap', name: 'sikap'},
                {data: 'score', name: 'score'},
                {data: 'predicate', name: 'predicate'},
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
                        var teori = $('#teori-form').val();
                        var keterampilan = $('#keterampilan-form').val();
                        var keselamatan = $('#keselamatan-form').val();
                        var disiplin = $('#disiplin-form').val();
                        var sikap = $('#sikap-form').val();
                        var score = $('#score-form').val();
                        var predicate = $('#predicate-form').val();

                        if(window.location.href.includes('public')){
                            location.href = `http://prakerinsmk.test/public/report/evaluation/download?nisn=${nisn}&student=${student}&department=${department}&teori=${teori}&keterampilan=${keterampilan}&keselamatan=${keselamatan}&disiplin=${disiplin}&sikap=${sikap}&score=${score}&predicate=${predicate}`
                        }else{
                            location.href = `http://prakerinsmk.test/report/evaluation/download?nisn=${nisn}&student=${student}&department=${department}&teori=${teori}&keterampilan=${keterampilan}&keselamatan=${keselamatan}&disiplin=${disiplin}&sikap=${sikap}&score=${score}&predicate=${predicate}`
                        }
                    }
                }
                // 'pdf', 'excel', 'csv'
            ],
        });
    });
  </script>
@endsection