<table>
        <thead>
            <tr>
                <th>Plat Nomor</th>
                <th>Pemilik</th>
                <th>Pengemudi</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
        @foreach($logs as $log)
            <tr>
                <td>{{ $log->cars->car_plat_number }} </td>
                <td>{{ $log->owners->owner_name }}</td>
                <td>
                    @if($log->driver_id != NULL)
                        {{ $log->drivers->driver_name }} 
                    @else
                        {{ $log->owners->owner_name }}
                    @endif
                </td>
                <td >
                    @if($log->status === 'IN')
                        {{ $log->status }}
                    @else
                        {{ $log->status }}
                    @endif
                </td>   
                <td>{{ $log->created_at }}</td>       
            </tr>
        @endforeach
        </tbody>
    </table>
        