<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Tamu Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">➕ Tambah Tamu Baru</h4>
                </div>
                <div class="card-body">


                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                  @endif

                @if ($errors->any())
                <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                </div>
                @endif


                    <form action="{{ route('tamus.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan nama" required>
                        </div>

                        <div class="mb-3">
                            <label for="instansi" class="form-label">Instansi</label>
                            <input type="text" name="instansi" id="instansi" class="form-control" placeholder="Masukkan instansi" required>
                        </div>

                        <div class="mb-3">
                            <label for="tujuan" class="form-label">Tujuan</label>
                            <select name="tujuan" id="tujuan" class="form-select" required>
                                <option value="">-- Pilih Tujuan --</option>
                                <option value="Membaca">Membaca</option>
                                <option value="Meminjam Buku">Meminjam Buku</option>
                                <option value="Mengembalikan Buku">Mengembalikan Buku</option>
                                <option value="Mencari Referensi">Mencari Referensi</option>
                                <option value="Diskusi/Belajar Kelompok">Diskusi / Belajar Kelompok</option>
                                <option value="Menggunakan Fasilitas (Komputer/Internet)">Menggunakan Fasilitas (Komputer/Internet)</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-between">
                            {{-- <a href="{{ route('tamus.index') }}" class="btn btn-secondary">⬅️ Kembali</a> --}}
                            <button type="submit" class="btn btn-primary">💾 Simpan Tamu</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Hilangkan pesan sukses otomatis
    setTimeout(() => {
        const alert = document.querySelector('.alert-success');
        if (alert) alert.remove();
    }, 3000);

    // Bersihkan form setelah sukses submit
    @if(session('success'))
        document.querySelector('form').reset();
    @endif
</script>

</body>
</html>
