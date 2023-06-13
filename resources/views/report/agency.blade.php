@extends('layout.report')

@section('content')
<table class="table mt-2 content-table">
    <tr>
        <th>No</th>
        <th>Instansi</th>
        <th>Pimpinan</th>
        <th>Alamat</th>
        <th>Karakteristik</th>
    </tr>
    @for ($i = 0; $i < count($data); $i++)
        <tr>
            <td class="text-center" style="width: ">
                {{ $i+1 }}
            </td>
            <td>
                {{ $data[$i]->name }} <br>
                {{ $data[$i]->region->name ?? $data[$i]->region }}
            </td>
            <td>
                {{ $data[$i]->leader }} <br>
                {{ $data[$i]->nip }} <br>
                {{ $data[$i]->phone }} 
            </td>
            <td>{{ $data[$i]->address }}</td>
            <td>
                <ol>
                    @foreach (explode(',', $data[$i]->characteristic) as $characteristic)
                      <li>
                        {{ trim($characteristic) }}
                      </li>
                    @endforeach
                </ol>
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