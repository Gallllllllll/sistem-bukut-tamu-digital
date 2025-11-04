<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Statistik Tamu</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: center; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Laporan Statistik Tamu</h2>
    <p>Tanggal terakhir: {{ $terakhir }}</p>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jumlah Tamu</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $d)
            <tr>
                <td>{{ $d->tanggal }}</td>
                <td>{{ $d->jumlah }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
