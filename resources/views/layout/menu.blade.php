<li class="nav-header">Dashboard</li>
<li class="nav-item">
    <a href="{{ route('home') }}" class='nav-link @if($menu == "home") active @endif'>
        <i class="nav-icon fas fa-th"></i>
        <p>Beranda</p>
    </a>
</li>

@if (Auth::user()->role == "SUPERADMIN" || Auth::user()->role == "ADMIN")
    <li class="nav-header">Akun</li>
@endif
@if (Auth::user()->role == "SUPERADMIN")
    <li class="nav-item">
        <a href="{{ route('admin') }}" class="nav-link @if($menu == 'admin') active @endif">
            <i class="nav-icon fas fa-user-cog"></i>
            <p> Admin </p>
        </a>
    </li>
@endif
@if (Auth::user()->role == "SUPERADMIN" || Auth::user()->role == "ADMIN")
    <li class="nav-item">
        <a href="{{ route('student') }}" class="nav-link @if($menu == "student") active @endif">
            <i class="nav-icon fas fa-user"></i>
            <p> Siswa </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('teacher') }}" class="nav-link @if($menu == "teacher") active @endif">
            <i class="nav-icon fas fa-user-tie"></i>
            <p> Guru </p>
        </a>
    </li>
    <li class="nav-item">
      <a href="{{ route('student-report-title.index') }}" class="nav-link @if($menu == "report-student") active @endif">
          <i class="nav-icon fas fa-user-tie"></i>
          <p> Judul Laporan </p>
      </a>
  </li>
@endif

@if (Auth::user()->role == "SUPERADMIN")
    <li class="nav-header">Sekolah</li>
    <li class="nav-item">
        <a href="{{ route('class') }}" class="nav-link @if($menu == "class") active @endif">
            <i class="nav-icon fas fa-users"></i>
            <p> Jurusan dan Kelas </p>
        </a>
    </li>
@endif

@if (Auth::user()->role == "SUPERADMIN" || Auth::user()->role == "ADMIN")
    <li class="nav-header">Pembimbing</li>
    <li class="nav-item">
        <a href="{{ route('mentor') }}" class="nav-link @if($menu == "mentor") active @endif">
            <i class="nav-icon fas fa-user-cog"></i>
            <p> Guru Pembimbing </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('mentoring') }}" class="nav-link @if($menu == "mentoring") active @endif">
            <i class="nav-icon fas fa-user"></i>
            <p> Guru Pembimbing Siswa </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('monitoring-admin.index') }}" class="nav-link @if($menu == "monitoring") active @endif">
            <i class="nav-icon fas fa-user"></i>
            <p> Monitoring </p>
        </a>
    </li>
@endif

<li class="nav-header">Data Instansi</li>
<li class="nav-item">
    <a href="{{ route('region') }}" class="nav-link @if($menu == "region") active @endif">
        <i class="nav-icon fas fa-border-none"></i>
        <p>Wilayah</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('agency') }}" class="nav-link @if($menu == "agency") active @endif">
        <i class="nav-icon fas fa-building"></i>
        <p>Industri</p>
    </a>
</li>

@if (Auth::user()->role == "SUPERADMIN" || Auth::user()->role == "ADMIN")
<li class="nav-item @if (str_contains($menu, 'report')) menu-open @endif">
    <a href="#" class="nav-link">
      <i class="nav-icon fas fa-chart-pie"></i>
      <p>
        Laporan
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ route('report.region.index') }}" class="nav-link @if ($menu == "region-report") active @endif">
            <i class="far fa-circle nav-icon"></i>
            <p>Wilayah</p>
          </a>
        </li>
    </ul>
    <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ route('report.agency.index') }}" class="nav-link @if ($menu == "agency-report") active @endif">
            <i class="far fa-circle nav-icon"></i>
            <p>industri</p>
          </a>
        </li>
    </ul>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="{{ route('report.student.index') }}" class="nav-link @if ($menu == "student-report") active @endif">
          <i class="far fa-circle nav-icon"></i>
          <p>Siswa</p>
        </a>
      </li>
    </ul>
    <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ route('report.teacher.index') }}" class="nav-link @if ($menu == "teacher-report") active @endif">
            <i class="far fa-circle nav-icon"></i>
            <p>Guru</p>
          </a>
        </li>
    </ul>
    <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ route('report.mentor.index') }}" class="nav-link @if ($menu == "mentor-report") active @endif">
            <i class="far fa-circle nav-icon"></i>
            <p>Guru Pembimbing</p>
          </a>
        </li>
    </ul>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="{{ route('report.mentoring.index') }}" class="nav-link  @if ($menu == "mentoring-report") active @endif">
          <i class="far fa-circle nav-icon"></i>
          <p>Guru Pembimbing Siswa</p>
        </a> 
      </li>
    </ul>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="{{ route('report.journal-summary.index') }}" class="nav-link @if ($menu == "journal-report") active @endif">
          <i class="far fa-circle nav-icon"></i>
          <p>Jurnal Kegiatan</p>
        </a> 
      </li>
    </ul>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="{{ route('report.monitoring.index') }}" class="nav-link @if ($menu == "monitoring-report") active @endif">
          <i class="far fa-circle nav-icon"></i>
          <p>Bimbingan</p>
        </a> 
      </li>
    </ul>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="{{ route('report.attendance-summary.index') }}" class="nav-link @if ($menu == "attendance-report") active @endif">
          <i class="far fa-circle nav-icon"></i>
          <p>Absensi</p>
        </a> 
      </li>
    </ul>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="{{ route('report.evaluation.index') }}" class="nav-link @if ($menu == "evaluation-report") active @endif">
          <i class="far fa-circle nav-icon"></i>
          <p>Penilaian</p>
        </a> 
      </li>
    </ul>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="{{ route('report.student-report-title.index') }}" class="nav-link @if ($menu == "title-report") active @endif">
          <i class="far fa-circle nav-icon"></i>
          <p>Judul Laporan</p>
        </a> 
      </li>
    </ul>
  </li>
@endif

<li class="nav-item">
    <a href="{{ route('logout') }}" class="nav-link bg-danger">
        <i class="nav-icon fas fa-sign-out-alt"></i>
        <p>Logout</p>
    </a>
</li>