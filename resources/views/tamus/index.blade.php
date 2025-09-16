<!DOCTYPE html>
<html>
<head>
    <title>Daftar Tamu</title>
    <style>
        table { border-collapse: collapse, width: 100%; }
        th, td{ border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        input { padding: 5px; margin-right: 5px; }
        a { margin-right: 10px; }
    </style>
</head>
<body>
<h1>Daftar Tamu</h1>

<a href="{{ route('tamus.create') }}">Tambah Tamu Baru</a>
<a href="{{ route('tamus.exportExcel') }}">Export Excel</a>
<a href="{{ route('tamus.exportPDF') }}">Export PDF</a>
<a href="{{route('tamus.statistik') }}">Lihat Statistik</a>

<form method="GET" action="{{ route('tamus.index') }}">
    <input type="text" name="search" placeholder="Cari nama/instansi/tanggal" value="{{ request('search') }}">
    <button type="submit">Cari</button>
</form>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<table>
<tr>
    <th>Nama</th>
    <th>Instansi</th>
    <th>Tujuan</th>
    <th>Waktu Kedatangan</th>
</tr>
@foreach($tamus as $tamu)
<tr>
    <td>{{ $tamu->nama }}</td>
    <td>{{ $tamu->instansi }}</td>
    <td>{{ $tamu->tujuan }}</td>
    <td>{{ $tamu->waktu_kedatangan }}</td>
</tr>
@endforeach
</table>
</body>
</html>