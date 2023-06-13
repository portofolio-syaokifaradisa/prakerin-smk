@extends('layout.report')

@section('content')
<table class="table mt-2 content-table">
    <thead>
        <tr>
          <th style="width: 7%">No</th>
          <th>Industri</th>
          <th>Pembimbing</th>
          <th>Tanggal</th>
          <th>Isi Monitoring</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($data as $index => $data)
          <tr>
            <td>{{ $index + 1 }}</td>
            <td>
              {{ $data->application_letter->agency->name }} <br>
              {{ $data->application_letter->Student->grade_class->Department->name }}
            </td>
            <td>{{ $data->teacher->name ?? $data->teacher }}</td>
            <td>{{ date('d-m-Y', strtotime($data->date)) }}</td>
            <td>{{ $data->description }}</td>
          </tr>
        @endforeach
      </tbody>
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