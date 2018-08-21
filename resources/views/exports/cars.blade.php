<table>
        <thead>
            <tr>
                <th>Jenis Mobil</th>
                <th>Plat Mobil</th>
                <th>Nomor Rangka</th>
                <th>Nomor Mesin</th>
                <th>Rute</th>
                <th>Pemilik</th>
                <th>Barcode</th>
                <th>Status</th>
                <th>Registered</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cars as $item)
                <tr>
                    <td>{{ $item->car_type }}</td>
                    <td>{{ $item->car_plat_number }}</td>
                    <td>{{ $item->car_frame_number }}</td>
                    <td>{{ $item->car_machine_number }}</td>
                    <td>{{ $item->car_rute }}</td>
                    <td>{{ $item->owners->owner_name }}</td>
                    <td>{{ $item->car_barcode }}</td>
                    <td>
                        @if($item->status == 0)
                            Not Activated
                        @else
                            Activated
                        @endif
                    </td>
                    <td>{{ $item->created_at }}</td>               
                </tr>
            @endforeach
        </tbody>
    </table>
        