<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Daftar Tamu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            height: 100vh;
            background-color: #8b0000; /* merah tua elegan */
            color: white;
            padding-top: 20px;
            position: fixed;
            width: 230px;
            z-index: 1000;
        }
        .sidebar a {
            color: white;
            display: block;
            padding: 10px 20px;
            text-decoration: none;
            font-weight: 500;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: #a52a2a;
            border-radius: 8px;
        }
        .main-content {
            margin-left: 240px;
            padding: 20px;
        }
        .navbar-custom {
            background-color: white;
            border-bottom: 1px solid #ddd;
            padding: 10px 20px;
            position: sticky;
            z-index: 1050;
            top: 0;
        }
        .navbar-custom h4 {
            margin: 0;
            font-weight: 600;
        }

        @media (max-width: 992px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: sticky;
                top: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                background-color: #8b0000;
                flex-wrap: wrap;
                gap: 10px;
                padding: 10px;
                z-index: 1050;
                box-shadow: 0 2px 5px rgba(0,0,0,0.15);
            }
            .sidebar h4 {
                display: none;
            }
            .sidebar a {
                display: inline-block;
                padding: 8px 15px;
                border-radius: 6px;
                background-color: #a52a2a;
                font-size: 0.9rem;
            }
            .main-content {
                margin-left: 0;
                margin-top: 10px;
                padding: 15px;
            }
            .navbar-custom {
                position: sticky; 
                top: 60px;
                z-index: 1010;
                flex-direction: column;
                align-items: flex-start !important;
                gap: 8px;
            }
            .table {
                font-size: 0.9rem;
            }
            .card {
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>

    {{-- Sidebar --}}
    <div class="sidebar">
        <div class="text-center mb-4">
            <h4 class="fw-bold">📚 E-Library</h4>
        </div>
        <a href="{{ route('tamus.index') }}" class="active">📖 Daftar Tamu</a>
        <a href="{{ route('tamus.statistik') }}">📊 Statistik</a>
        <a href="{{ url('/logout') }}">🚪 Logout</a>
    </div>

    {{-- Main Content --}}
    <div class="main-content">
        {{-- Navbar --}}
        <div class="navbar-custom d-flex justify-content-between align-items-center mb-4">
            <h4>📖 Daftar Tamu</h4>
        </div>

        {{-- Tombol aksi --}}
        <div class="mb-3 d-flex flex-wrap gap-2">
            <a href="{{ route('tamus.create') }}" class="btn btn-primary">➕ Tambah Tamu Baru</a>
            <a href="{{ route('tamus.exportExcel') }}" class="btn btn-success">⬇️ Export Excel</a>
            <a href="{{ route('tamus.exportPDF') }}" class="btn btn-danger">⬇️ Export PDF</a>
        </div>

        {{-- Form pencarian --}}
        <form method="GET" action="{{ route('tamus.index') }}" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" 
                       placeholder="Cari nama / instansi / tanggal" 
                       value="{{ request('search') }}">
                <button class="btn btn-outline-secondary" type="submit">Cari</button>
            </div>
        </form>

        {{-- Pesan sukses --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Tabel tamu --}}
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
