<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>{{ "Prakerin SMK | " . $title }}</title>
  <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}" />

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendor/adminlte/adminlte.min.css') }}">

  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('vendor/datatables/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendor/datatables/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendor/datatables/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendor/daterangepicker/daterangepicker.css') }}">
  <link rel="stylesheet" href="{{ asset('vendor/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">

  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>

  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    function deleteItem(url){
      Swal.fire({
        title: 'Konfirmasi Hapus?',
        text: "Yakin Ingin Menghapus!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.replace(url);
        }
      })
  }

  function confirmationAlert(title, description, url){
      Swal.fire({
        title: title,
        text: description,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.replace(url);
        }
      })
  }
  </script>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown user-menu py-2">
            <span class="d-none d-md-inline mr-3">Hai, <strong>{{ Auth::user()->information->name }}</strong></span>
        </li>
    </ul>
  </nav>

  <aside class="main-sidebar sidebar-light-primary elevation-1">
    <a href="{{ route('home') }}" class="brand-link">
      <img src="{{ asset('img/logo.png') }}"  style="width: 50px; height:50px" class="align-middle ml-3">
      <span class="ml-1 align-middle brand-text font-weight-light"><b class="h4">Prakerin SMK</b></span>
    </a>

    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          @include('layout.menu')
        </ul>
      </nav>
    </div>
  </aside>

  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">{{ $title }}</h1>
          </div>
          <div class="col-sm-6">
          </div>
        </div>
      </div>
    </div>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            @yield('content')
          </div>
        </div>
      </div>
    </div>
  </div>

  <footer class="main-footer text-center">
    <strong>Copyright &copy; 2022 <a href="{{ route('home') }}"> Prakerin SMK</a>.</strong>
  </footer>
</div>

<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title">Hapus Data</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <p>Yakin ingin menghapus?</p>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal"><i class="fa fa-chevron-left"></i> Batal</button>
              <a class="btn btn-sm btn-danger btn-ok text-white"><i class="fa fa-trash"></i> Hapus</a>
          </div>
      </div>
  </div>
</div>

<script src="{{ asset('vendor/jquery/jquery.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>
<script src="{{ asset('vendor/moment/moment.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/adminlte.min.js') }}"></script>
<script src="{{ asset('vendor/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('vendor/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script src="{{ asset('vendor/bs-stepper/js/bs-stepper.min.js') }}"></script>
<script src="{{ asset('vendor/dropzone/min/dropzone.min.js') }}"></script>

<!-- DataTables  & Plugins -->
<script src="{{ asset('vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('vendor/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('vendor/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('vendor/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('vendor/datatables/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('vendor/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

<script>
  $(function () {
    bsCustomFileInput.init();
    $('#reservation').daterangepicker()
    
    $('.datatables').DataTable({
      dom: '<"row"<"col-md-8"l><"col-md-4"f>>rt<"row"<"col"i><"col"p>>',
      "responsive": true,
    });

    $('#modal-delete').on('show.bs.modal', function(e) {
        $(this).find('.modal-title').text("Hapus Data");
        $(this).find('.modal-footer').show();
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
      });
  });

  //Date picker
  $('#reservationdate').datetimepicker({
        format: 'L'
  });
</script>

</body>
</html>
