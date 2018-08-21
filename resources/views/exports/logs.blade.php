<table>
    <thead>
        <tr>
        <th>Indeks</th>
        <th>Plat Nomor</th>
        <th>Pemilik Mobil</th>
        <th>Jumlah Masuk</th>
        <th>Jumlah keluar</th>
        <th>Status</th>
        </tr>
    </thead>
    <tbody>
    @foreach($logs as $log)
        <tr>
            <td>{{ $log->indeks }}</td>
            <td>{{ $log->cars->car_plat_number }}</td>
            <td>{{ $log->owners->owner_name }}</td>
            <td>{{ $log->count_in }}</td>
            <td>{{ $log->count_out }}</td>
            <td>
                @if($log->count_in != $log->count_out)
                    Tidak Sesuai
                @else
                    Sesuai
                @endif
            </td>                  
        </tr>
    @endforeach
    </tbody>
</table>
    