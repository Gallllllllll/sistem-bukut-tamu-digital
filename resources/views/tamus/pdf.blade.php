<!DOCTYPE html>
<html>
<head>
    <title>Data Tamu</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
        }
    </style>
</head>
<body>
    <h2>Data Tamu</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Tujuan</th>
                <th>Waktu Kedatangan</th>
                <th>Created At</th>
                <th>Updated At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tamus as $tamu)
                <tr>
                    <td>{{ $tamu->id }}</td>
                    <td>{{ $tamu->nama }}</td>
                    <td>{{ $tamu->tujuan }}</td>
                    <td>{{ $tamu->waktu_kedatangan }}</td>
                    <td>{{ $tamu->created_at }}</td>
                    <td>{{ $tamu->updated_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
