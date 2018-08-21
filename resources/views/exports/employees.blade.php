<table>
    <thead>
        <tr>
            <th>Nama</th>
            <th>Username</th>
            <th>Registered</th>
        </tr>
    </thead>
    <tbody>
        @foreach($employees as $item)
            <tr>
                <td>{{ $item->employee_name }}</td>
                <td>{{ $item->employee_username }}</td>
                <td>{{ $item->created_at }}</td>               
            </tr>
        @endforeach
    </tbody>
</table>
    