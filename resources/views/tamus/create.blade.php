<!DOCTYPE html>
<html>
<head>
    <title>Tambah Tamu Baru</title>
    <style>
        input { padding: 5px; margin-bottom: 10px; display: block; width: 300px; }
        button { padding: 5px 10px; }
        a { display: inline-block; margin-top: 10px; }
    </style>
</head>
<body>
<h1>Tambah Tamu Baru</h1>

<form method="POST" action="{{ route('tamus.store') }}">
    @csrf
    <input type="text" name="nama" placeholder="Nama" required>
    <input type="text" name="instansi" placeholder="Instansi" required>
    <input type="text" name="tujuan" placeholder="Tujuan" required>
    <button type="submit">Simpan Tamu</button>
</form>

<a href="{{ route('tamus.index') }}">Kembali ke Daftar Tamu</a>
</body>
</html>
