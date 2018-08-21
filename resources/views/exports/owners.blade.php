<table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Nomor KTP</th>
                <th>Alamat</th>
                <th>Registered</th>
            </tr>
        </thead>
        <tbody>
            @foreach($owners as $item)
                <tr>
                    <td>{{ $item->owner_name }}</td>
                    <td>{{ $item->owner_identity_number }}</td>
                    <td>{{ $item->created_at }}</td>               
                </tr>
            @endforeach
        </tbody>
    </table>
        