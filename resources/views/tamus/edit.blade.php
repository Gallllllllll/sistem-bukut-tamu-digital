<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Biodata Tamu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4 fw-bold">Edit Biodata Tamu</h2>

    <form action="{{ route('tamus.update', $tamu->id) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama', $tamu->nama) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Instansi</label>
            <input type="text" name="instansi" class="form-control" value="{{ old('instansi', $tamu->instansi) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Tujuan</label>
            <select name="tujuan" class="form-control" required>
                <option value="">-- Pilih Tujuan --</option>
                <option value="Membaca" {{ old('tujuan', $tamu->tujuan) == 'Membaca' ? 'selected' : '' }}>Membaca</option>
                <option value="Meminjam Buku" {{ old('tujuan', $tamu->tujuan) == 'Meminjam Buku' ? 'selected' : '' }}>Meminjam Buku</option>
                <option value="Mengembalikan Buku" {{ old('tujuan', $tamu->tujuan) == 'Mengembalikan Buku' ? 'selected' : '' }}>Mengembalikan Buku</option>
                <option value="Mencari Referensi" {{ old('tujuan', $tamu->tujuan) == 'Mencari Referensi' ? 'selected' : '' }}>Mencari Referensi</option>
                <option value="Diskusi / Belajar Kelompok" {{ old('tujuan', $tamu->tujuan) == 'Diskusi / Belajar Kelompok' ? 'selected' : '' }}>Diskusi / Belajar Kelompok</option>
                <option value="Menggunakan Fasilitas (Komputer/Internet)" {{ old('tujuan', $tamu->tujuan) == 'Menggunakan Fasilitas (Komputer/Internet)' ? 'selected' : '' }}>Menggunakan Fasilitas (Komputer/Internet)</option>
                <option value="Lainnya" {{ old('tujuan', $tamu->tujuan) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Waktu Kedatangan</label>
            <input type="datetime-local" name="waktu_kedatangan" class="form-control"
                value="{{ old('waktu_kedatangan', $tamu->waktu_kedatangan ? date('Y-m-d\TH:i', strtotime($tamu->waktu_kedatangan)) : '') }}">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('tamus.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
</body>
</html>
