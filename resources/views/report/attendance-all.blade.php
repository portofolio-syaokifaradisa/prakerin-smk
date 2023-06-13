@extends('layout.report')

@section('content')
<table class="table mt-2 content-table">
    <tr>
        <th class="text-center" style="width: 7%">No</th>
        <th class="text-center">Industri</th>
        <th class="text-center">Nama Siswa</th>
        <th class="text-center">Tanggal</th>
        <th class="text-center">Jam</th>
        <th class="text-center">Status</th>
        <th class="text-center">Keterangan</th>
    </tr>
    @for ($i = 0; $i < count($data); $i++)
          <tr>
            <td class="text-center align-middle">{{ $i + 1 }}</td>
            <td class="text-center align-middle">
                {{ $data[$i]->application_letter->agency->name }}
            </td>
            <td class="align-middle">
              {{ $data[$i]->Student->name }} <br>
              {{ $data[$i]->Student->grade_class->Department->name }} 
            </td>
            <td class="text-center align-middle">
              {{ date('d-m-Y', strtotime($data[$i]->date)) }}
            </td>
            <td class="text-center align-middle">
              @if ($data[$i]->in)
                {{ date('H:m', strtotime($data[$i]->in)) . " - ". date('H:m', strtotime($data[$i]->out)) }}
              @else
                -
              @endif
            </td>
            <td class="text-center align-middle">
              @if ($data[$i]->isAlpha)
                Alpha
              @elseif ($data[$i]->isPermit)
                Izin
              @elseif ($data[$i]->isSick)
                Sakit
              @else
                Hadir
              @endif
            </td>
            <td class="align-middle">
              {{ $data[$i]->description ?? '-' }}
            </td>
          </tr>
        @endfor
</table>

<table class="mt-5 ttd">
    <tr>
        <td style="width: 70%">

        </td>
        <td style="width: auto">
            Haruyan, {{ FormatHelper::toIndonesianDateFormat(date('d-m-Y', strtotime(now()))) }} <br>
            Kepala SMK AL Hidayah Barabai
            <br>
            <br>
            <br>
            <br>
            Akhmad Rahman, S.Pd <br>
            NIP.-
        </td>
    </tr>
</table>
@endsection