<table>
    <thead>
        <tr>
            <th>Nama</th>
            <th>Nomor KTP</th>
            <th>Alamat</th>
            <th>Rute</th>
            <th>Plat Mobil</th>
            <th>Registered</th>
        </tr>
    </thead>
    <tbody>
        @foreach($drivers as $item)
            <tr>
                <td>{{ $item->driver_name }}</td>
                <td>{{ $item->driver_identity_number }}</td>
                <td>{{ $item->driver_address }}</td>
                <td>{{ $item->driver_rute }}</td>
                <td>{{ $item->cars->car_plat_number }}</td>
                <td>{{ $item->created_at }}</td>               
            </tr>
        @endforeach
    </tbody>
</table>
    