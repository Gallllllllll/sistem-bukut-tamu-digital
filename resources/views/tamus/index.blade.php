<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Tamu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite('resources/css/app.css')
</head>
<body class="bg-light">

<div class="container py-5">
    <h1 class="mb-4 text-center">📖 Daftar Tamu</h1>

    {{-- tombol logout --}}
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ url('/logout') }}" class="btn btn-danger">
            🚪 Logout
        </a>
    </div>



    {{-- tombol aksi --}}
    <div class="mb-3 d-flex flex-wrap gap-2">
        <a href="{{ route('tamus.create') }}" class="btn btn-primary">➕ Tambah Tamu Baru</a>
        <a href="{{ route('tamus.exportExcel') }}" class="btn btn-success">⬇️ Export Excel</a>
        <a href="{{ route('tamus.exportPDF') }}" class="btn btn-danger">⬇️ Export PDF</a>
        <a href="{{ route('tamus.statistik') }}" class="btn btn-info text-white">📊 Lihat Statistik</a>
    </div>

    {{-- form pencarian --}}
    <form method="GET" action="{{ route('tamus.index') }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" 
                   placeholder="Cari nama / instansi / tanggal" 
                   value="{{ request('search') }}">
            <button class="btn btn-outline-secondary" type="submit">Cari</button>
        </div>
    </form>

    {{-- pesan sukses --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- tabel tamu --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Instansi</th>
                        <th>Tujuan</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tamus as $index => $tamu)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $tamu->nama }}</td>
                        <td>{{ $tamu->instansi }}</td>
                        <td>{{ $tamu->tujuan }}</td>
                        <td>{{ $tamu->created_at->format('d M Y H:i') }}</td>
                        <td>
                            <form action="{{ route('tamus.destroy', $tamu->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">🗑️ Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
